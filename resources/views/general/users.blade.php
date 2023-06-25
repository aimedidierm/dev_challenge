@extends('layout')

@section('content')

<x-general-nav />

<div class="p-4 sm:ml-64">
    <div class="rounded-lg dark:border-gray-700">
        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-gray">
            Pending users
        </h1>
        <br>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Role
                        </th>
                        <th scope="col" class="px-6 py-3">

                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if ($data->isEmpty())
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" colspan="4"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            No data in table
                        </th>
                    </tr>
                    @endif
                    @foreach ($data as $item)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$item->name}}
                        </th>
                        <td class="px-6 py-4">
                            {{$item->email}}
                        </td>
                        <td class="px-6 py-4">
                            @if ($item->role == 'project')
                            {{'Project Manager'}}
                            @else
                            {{'Finance Manager'}}
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="/general/user/approve/{{ $item->id }}"
                                style="border-radius: 8px;border: none;background-color: #199649;color: white;padding: 10px 20px;">Approve</a>
                            <a href="/general/user/reject/{{ $item->id }}"
                                style="border-radius: 8px;border: none;background-color: #f44336;color: white;padding: 10px 20px;">Reject</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@stop