<?php

namespace App\Livewire;

use App\Models\Gate;
// use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class GateTable extends PowerGridComponent
{
    use WithExport;

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Header::make()
                ->showToggleColumns()
                ->showSearchInput(),

            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    #[On('gate-added')]
    public function updateList()
    {
        $this->refresh();
    }


    public function datasource(): Builder
    {
        return Gate::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name');
            // ->add('created_at');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),

            Column::make('Name', 'name')
                ->searchable()
                ->sortable()
                ->editOnClick(),

            // Column::make('Created at', 'created_at')
            //     ->sortable()
            //     ->searchable(),

            // Column::action('Actions')
        ];
    }

    public function filters(): array
    {
        return [
            // Filter::inputText('name', 'name'),
            // Filter::datepicker('created_at', 'created_at'),
        ];
    }

    #[On('delete')]
    public function delete($rowId): void
    {
        $this->js('alert(' . $rowId . ')');
    }

    // public function actions(Gate $row): array
    // {
    //     return [
    //         Button::add('delete')
    //             ->slot('Delete')
    //             ->id()
    //             ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
    //             ->dispatch('delete', ['rowId' => $row->id])
    //     ];
    // }


    public function onUpdatedEditable(string|int $id, string $field, string $value): void
    {
        // $this->validate();

        $gate = Gate::findOrFail($id);

        $gate->update([$field => $value]);
    }
}
