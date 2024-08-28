<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalhes do Produto') }}
        </h2>

    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> 
            <!-- Start coding here -->
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                
                            </thead>
                            <tbody>
                                <div class="grid gap-6 mb-2 md:grid-cols-2">
                                    <div class="my-4" >
                                        @if ($produto->image == 'default.jpg')
                                            <div>
                                                <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-10.jpg" alt="">
                                            </div>
                                        @else
                                            <div>
                                                <img class="h-auto max-w-full rounded-lg" src="{{ asset('images/' . $produto->image) }}" alt="">
                                            </div>
                                        @endif
                                    </div>
                                    <div>                                        
                                        <ol class="my-4 mb-2 space-y-4 text-gray-500 list-medium list-inside dark:text-white">                                               
                                            <ul class="ps-5 mt-2 space-y-1 list-disc list-inside">
                                                <li>{{ $produto->nome }}</li>
                                                <li>{{ $produto->valor.'$' }}</li>
                                                <li>{{ $produto->categoria->nome }}</li>
                                                <li>{{ $produto->marca->nome }}</li>
                                                <li>{{ $produto->descricao }}</li>
                                            </ul>                                    
                                        </ol>                                         
                                    </div>
                                </div>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</x-app-layout>
