<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Saida de Compras') }}
        </h2>
    </x-slot>

    <section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-8">
        
            <div class="mx-auto max-w-5xl px-4 2xl:px-0">
                <div class="grid md:grid-cols-2 md:gap-12">
                    <div class="mb-6 md:mb-8">
                            <div class="divide-y divide-gray-200 dark:divide-gray-800 mb-4 md:mb-8">
                                <form action="{{ route('vendas.store') }}" method="POST">
                                    @csrf
                                    @foreach ($saidas as $item)
                                        <input type="hidden" name="items[{{ $loop->index }}][produto_id]" value="{{ $item->produto->id }}">
                                        <input type="hidden" name="items[{{ $loop->index }}][quantidade]" value="{{ $item->quantidade }}">
                                        <dl class="sm:flex items-center justify-between gap-4 pb-3">
                                            <img src="{{ asset('images/' . $item->produto->image) }}" alt="" class="items-center w-8 rounded">
                                            <dt class="font-normal mb-1 sm:mb-0 text-gray-500 dark:text-gray-400">{{ $item->produto->nome }}</dt>
                                            <dd class="font-medium text-gray-900 dark:text-white sm:text-end">{{ $item->produto->valor }},00$</dd>
                                            <dd>
                                                <form action="{{ route('saidas.ajustarQuantidade', $item->id) }}" method="POST" class="max-w-xs mx-auto">
                                                    @csrf
                                                    <label for="counter-input-{{ $item->id }}" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white"></label>
                                                    <div class="relative flex items-center">
                                                        <button type="button" id="decrement-button-{{ $item->id }}" data-input-counter-decrement="counter-input-{{ $item->id }}" class="flex-shrink-0 bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 inline-flex items-center justify-center border border-gray-300 rounded-md h-5 w-5 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                                            <svg class="w-2.5 h-2.5 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
                                                            </svg>
                                                        </button>
                                                        <input type="text" id="counter-input-{{ $item->id }}" name="quantidade" data-input-counter class="flex-shrink-0 text-gray-900 dark:text-white border-0 bg-transparent text-sm font-normal focus:outline-none focus:ring-0 max-w-[2.5rem] text-center" placeholder="" value="{{ $item->quantidade }}" min="1" required />
                                                        <button type="button" id="increment-button-{{ $item->id }}" data-input-counter-increment="counter-input-{{ $item->id }}" class="flex-shrink-0 bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 inline-flex items-center justify-center border border-gray-300 rounded-md h-5 w-5 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                                            <svg class="w-2.5 h-2.5 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                                                            </svg>
                                                        </button>
                                                        <button type="submit" class=" text-blue-500">Atualizar</button>
                                                    </div>
                                                </form>
                                            </dd>
                                            <dd>
                                                <form action="{{ route('saidas.remover', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500">Remover</button>
                                                </form>
                                            </dd>
                                        </dl>
                                    @endforeach
                                    <button type="submit" class="text-green-500">Concluir</button>

                                </form>
                                
                            </div>
                        
         
                    </div>

                    <div class="space-x-4">
                        <div class="rounded-lg border border-gray-100 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800">
                            <p class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Resumo</p>
                            <div class="relative overflow-x-auto">
                                <table class="w-full text-left font-medium text-gray-900 dark:text-white md:table-fixed">
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                        <tr>
                                            <td class="text-base font-normal text-gray-500 dark:text-gray-400">Subtotal</td>
                                            <td class="text-base font-medium text-gray-900 dark:text-white">{{ $subtotal }},00$</td>
                                        </tr>
                                        <tr>
                                            <td class="text-base font-normal text-gray-500 dark:text-gray-400">Descontos</td>
                                            <td class="text-base font-medium text-green-500">-{{ $descontos }},00$</td>
                                        </tr>
                                        <tr class="border-t border-gray-200 pt-2 text-lg font-bold text-gray-900 dark:border-gray-600 dark:text-white">
                                            <td>Total</td>
                                            <td>{{ $total }},00$</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

         
    </section>
</x-app-layout>
