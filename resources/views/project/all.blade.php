@extends('layout')

@section('content')

<x-project-nav />

<div class="p-4 sm:ml-64">
    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-gray">
        All tools
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
                        Price/Unit
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Units
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Total
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3">

                    </th>
                </tr>
            </thead>
            <tbody>
                @if ($data->isEmpty())
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" colspan="6"
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
                        {{$item->price_unity}}
                    </td>
                    <td class="px-6 py-4">
                        {{$item->unity}}
                    </td>
                    <td class="px-6 py-4">
                        {{$item->total}}
                    </td>
                    <td
                        class="px-6 py-4 @if($item->status == 'pending'||$item->status == 'financeApproved') {{'text-yellow-400'}} @elseif($item->status == 'generalApproved' ) {{'text-green-400'}}  @elseif($item->status == 'rejected') {{'text-red-400'}} @endif">
                        @if ($item->status == 'pending'||$item->status == 'financeApproved')
                        {{'Pending'}}
                        @elseif ($item->status == 'generalApproved')
                        {{'Approved'}}
                        @else
                        {{'Rejected'}}
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <form method="POST" action="/project/all/{{ $item->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                style="border-radius: 8px;border: none;background-color: #f44336;color: white;padding: 10px 20px;">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>

@stop