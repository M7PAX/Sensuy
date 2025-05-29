<?php

declare(strict_types=1);

namespace App\Orchid\Screens\User;

use App\Models\User; // Correct model namespace
use App\Orchid\Layouts\User\UserEditLayout;
use App\Orchid\Layouts\User\UserPasswordLayout;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Access\Impersonation;
use Orchid\Support\Facades\Dashboard;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class UserEditScreen extends Screen
{
    /**
     * @var User
     */
    public $user;

    /**
     * Fetch data to be displayed on the screen.
     */
    public function query(User $user): iterable
    {
        // $user->load(['roles']); // Eager load roles if UserRoleLayout is active and uses it
        return [
            'user'       => $user,
            // 'permission' is not strictly needed here if RolePermissionLayout now only handles 'is_admin'
            // and doesn't display Orchid's full permission matrix.
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return $this->user->exists ? 'Edit User' : 'Create User';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Manage user profile, password, and administrator status.';
    }

    /**
     * The screen's available permissions.
     */
    public function permission(): ?iterable
    {
        return [
            'platform.systems.users',
        ];
    }

    /**
     * The screen's action buttons.
     */
    public function commandBar(): iterable
    {
        return [
            // Button::make(__('Impersonate user'))
            //     ->icon('bs.box-arrow-in-right')
            //     ->confirm(__('You can revert to your original state by logging out.'))
            //     ->method('loginAs')
            //     ->canSee($this->user->exists && $this->user->id !== \request()->user()->id),

            Button::make(__('Remove'))
                ->icon('bs.trash3')
                ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                ->method('remove')
                ->canSee($this->user->exists),

            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save'),
        ];
    }

    /**
     * The screen's layout elements.
     */
    public function layout(): iterable
    {
        $layouts = [
            Layout::block(UserEditLayout::class)
                ->title(__('Profile Information'))
                ->description(__('Update your account\'s profile information and email address.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->canSee($this->user->exists)
                        ->method('save')
                ),

            Layout::block(UserPasswordLayout::class)
                ->title(__('Password'))
                ->description(__('Ensure your account is using a long, random password to stay secure.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->canSee($this->user->exists)
                        ->method('save')
                ),
        ];

//        $layouts[] = Layout::block(RolePermissionLayout::class)
//            ->title(__('Administrator Status & Permissions'))
//            ->description(__('Set administrator status. If checked, the user will be granted all platform permissions. Granular permissions are managed elsewhere or through roles if administrator status is not checked.'))
//            ->commands(
//                Button::make(__('Save'))
//                    ->type(Color::BASIC)
//                    ->icon('bs.check-circle')
//                    ->canSee($this->user->exists)
//                    ->method('save')
//            );
//
////         If using UserRoleLayout for assigning specific roles:
//         $layouts[] = Layout::block(UserRoleLayout::class)
//             ->title(__('Roles'))
//             ->description(__('A Role defines a set of tasks a user assigned the role is allowed to perform.'))
//             ->commands(
//                 Button::make(__('Save'))
//                     ->type(Color::BASIC)
//                     ->icon('bs.check-circle')
//                     ->canSee($this->user->exists)
//                     ->method('save')
//             );

        return $layouts;
    }

    /**
     * @param User      $user
     * @param Request   $request
     * @param Dashboard $dashboard To get all platform permissions
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(User $user, Request $request, Dashboard $dashboard)
    {
        $request->validate([
            'user.email' => [
                'required',
                'email', // Good to have basic email validation
                Rule::unique(User::class, 'email')->ignore($user->id),
            ],
            'user.username' => 'required|string|max:255',
            // 'user.is_admin' => 'sometimes|boolean', // 'sometimes' if the field might not be present
            // but RolePermissionLayout should always submit it if it has sendTrueOrFalse()
        ]);

        // Collect main user data, excluding fields handled separately or within specific logic.
        $userData = $request->collect('user')->except(['password', 'permissions', 'roles'])->toArray();

        // Explicitly handle the 'is_admin' flag from the request.
        $userData['is_admin'] = $request->boolean('user.is_admin');

        if ($userData['is_admin']) {
            $userData['permissions'] = Dashboard::getAllowAllPermission()->toArray();
        }

        // Fill user data (including 'is_admin')
        $user->fill($userData);
        // Force fill the 'permissions' attribute separately, as it's handled by Orchid's special cast.
        $user->save();

        Toast::info(__('User was saved.'));

        return redirect()->route('platform.systems.users');
    }

    /**
     * @param User $user
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(User $user)
    {
        $user->delete();
        Toast::info(__('User was removed'));
        return redirect()->route('platform.systems.users');
    }

    /**
     * @param User $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginAs(User $user)
    {
        Impersonation::loginAs($user);
        Toast::info(__('You are now impersonating this user'));
        return redirect()->route(config('platform.index'));
    }
}
