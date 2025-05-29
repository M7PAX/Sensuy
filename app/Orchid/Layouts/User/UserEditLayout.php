<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Switcher; // <-- Add this
use Orchid\Screen\Layouts\Rows;

class UserEditLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('user.username')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Username'))
                ->placeholder(__('Username')),

            Input::make('user.email')
                ->type('email')
                ->required()
                ->title(__('Email'))
                ->placeholder(__('Email')),

            // Add the Switcher for is_admin
            Switcher::make('user.is_admin')
                ->sendTrueOrFalse() // Ensures true/false is sent
                ->title(__('Administrator'))
                ->placeholder(__('Make this user an administrator'))
                ->help(__('If checked, the user will have administrative privileges.')),

            // You might have other fields here like 'picture', 'theme', 'language'
            // Example:
            // Input::make('user.theme')
            //     ->type('text')
            //     ->title(__('Theme')),
            //
            // Input::make('user.language')
            //     ->type('text')
            //     ->title(__('Language')),
        ];
    }
}
