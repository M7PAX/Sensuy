<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Role;

// Remove Illuminate\Support\Collection if not used elsewhere after changes
// use Illuminate\Support\Collection;
use App\Models\User;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox; // You can also use Switcher here if you prefer
// use Orchid\Screen\Fields\Group; // No longer needed for a single checkbox
use Orchid\Screen\Layouts\Rows;
// use Throwable; // No longer throwing complex errors

class RolePermissionLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        /** @var User|null $user */
        $user = $this->query->get('user');

        // If there's no user context (e.g., on a create screen before user exists),
        // you might want to not show this or default it.
        // For editing, user should always exist.
        $isAdmin = $user && $user->exists ? $user->is_admin : false;

        return [
            CheckBox::make('user.is_admin') // IMPORTANT: Name it 'user.is_admin'
            ->value($isAdmin)
                ->title(__('Make this user an Administrator'))
                ->placeholder(__('Grant Administrator Privileges'))
                ->help(__('If checked, the user will have all administrative privileges. This overrides any granular permissions or roles for access control if your application logic prioritizes is_admin.'))
                ->sendTrueOrFalse(), // Ensures true/false (or 1/0) is sent
        ];
    }

    // The following methods are no longer needed as we are not generating
    // a list of permission checkboxes:
    // - generatedPermissionFields
    // - makeCheckBoxGroup
    // - makeCheckBox
    // - getIndeterminateStatus
}
