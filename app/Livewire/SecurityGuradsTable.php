<?php

namespace App\Livewire;

use App\Helpers\PowerGridThemes\TailwindStriped;
use App\Models\SecurityGuard;
// use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
// use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class SecurityGuradsTable extends PowerGridComponent
{
    use WithExport;

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            // Exportable::make('export')
            //     ->striped()
            //     ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            
            Header::make()
                ->showToggleColumns()
                ->showSearchInput(),
            
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    #[On('guard-added')] 
    public function updateList()
    {
        $this->refresh();
    }

    public function datasource(): Builder
    {
        return SecurityGuard::query()
            ->leftJoin('users', function ($users) {
                $users->on('security_guards.user_id', '=', 'users.id');
            })
            ->select('security_guards.*', 'users.name', 'users.email');
    }

    public function relationSearch(): array
    {
        return [
            'user' => [
                'name',
                'email',
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name', fn($guard) => e($guard->user->name))
            ->add('email', fn($guard) => e($guard->user->email))
            ->add('created_at');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id'),

            Column::add()
                ->title('Name')
                ->field('name')
                ->sortable()
                ->searchable()
                ->editOnClick(),

            Column::make('Email', 'email')
                ->sortable()
                ->searchable(),

            Column::make('Created At', 'created_at')
                ->sortable()
                ->searchable(),

            Column::action('Actions')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('name', 'name'),
            Filter::inputText('email', 'email'),
            Filter::datepicker('created_at', 'created_at'),
        ];
    }

    // #[On('change-password')]
    // public function changePassword($rowId): void
    // {
    //     $this->js('alert(' . $rowId . ')');
    // }

    public function actions(SecurityGuard $row): array
    {
        return [
            Button::add('change-password')
                ->slot('Change password')
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                // ->dispatch('edit', ['rowId' => $row->id])
        ];
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */

    public function onUpdatedEditable(string|int $id, string $field, string $value): void
    {
        // $this->validate();
        
        $guard = SecurityGuard::findOrFail($id);
        
        $guard->user->update([$field => $value]);
    }
    
    public function template(): ?string
    {
        return TailwindStriped::class;
    }
}
