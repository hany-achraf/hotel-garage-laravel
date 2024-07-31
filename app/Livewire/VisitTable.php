<?php

namespace App\Livewire;

use App\Models\Visit;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class VisitTable extends PowerGridComponent
{
    use WithExport;

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            
            Header::make()->showSearchInput(),
            
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Visit::query()
            ->leftJoin('users as users1', function ($users1) {
                $users1->on('entry_guard_id', '=', 'users1.id');
            })
            ->leftJoin('users as users2', function ($users2) {
                $users2->on('exit_guard_id', '=', 'users2.id');
            })
            ->leftJoin('gates as gates1', function ($gates1) {
                $gates1->on('entry_gate_id', '=', 'gates1.id');
            })
            ->leftJoin('gates as gates2', function ($gates2) {
                $gates2->on('exit_gate_id', '=', 'gates2.id');
            })
            ->select('visits.*', 'users1.name as entry_guard_name', 'users2.name as exit_guard_name', 'gates1.name as entry_gate_name', 'gates2.name as exit_gate_name');
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('qr_code')
            ->add('plate_no')
            ->add('email')
            ->add('phone_no')
            ->add('entry_guard_name')
            ->add('entry_gate_name')
            ->add('entry_time')
            ->add('exit_guard_name')
            ->add('exit_gate_name')
            ->add('exit_time')
            ->add('status', function($visit) {
                if (is_null($visit->exit_time)) {
                    return '<span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">' . __('Ongoing') . '</span>';
                } else {
                    return '<span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">' . __('Completed') . '</span>';
                }
            })
            ->add('created_at');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            // Column::make('Qr code', 'qr_code')
            //     ->searchable(),

            Column::make('Plate no', 'plate_no')
                ->searchable(),

            Column::make('Email', 'email')
                ->searchable(),

            Column::make('Phone no', 'phone_no')
                ->searchable(),

            Column::make('Entry guard', 'entry_guard_name'),
            Column::make('Entry gate', 'entry_gate_name'),
            Column::make('Entry time', 'entry_time')
                ->sortable()
                ->searchable(),

            
            Column::make('Status', 'status')
                ->searchable(),

            Column::make('Exit guard', 'exit_guard_name'),
            Column::make('Exit gate', 'exit_gate_name'),
            Column::make('Exit time', 'exit_time')
                ->sortable()
                ->searchable(),

            Column::make('Created at', 'created_at')
                ->sortable()
                ->searchable(),
        ];
    }

    public function filters(): array
    {
        return [
        ];
    }

    // #[\Livewire\Attributes\On('edit')]
    // public function edit($rowId): void
    // {
    //     $this->js('alert('.$rowId.')');
    // }

    // public function actions(Visit $row): array
    // {
    //     return [
    //         Button::add('edit')
    //             ->slot('Edit: '.$row->id)
    //             ->id()
    //             ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
    //             ->dispatch('edit', ['rowId' => $row->id])
    //     ];
    // }

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
}
