    <x-oferta-layout>
        <section class="h-full min-h-screen" style="background: rgb(221, 178, 37);">
            <div class="mx-auto max-w-screen-sm text-center p-5 mb-1 lg:mb-1">
                <p class="font-light text-gray-500 lg:mb-4 sm:text-xl dark:text-gray-400">Escolha as melhores ofertas do momento!</p>
            </div> 

            @if(count($produtos) == 0)
                <div class="flex justify-center py-4">
                    <span class="text-black dark:text-gray-600">{{ __('Nenhum Produto Cadastrado!') }}</span>
                </div>
            @else
                <div class="flex flex-col justify-center items-center px-20 gap-y-2">            
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        @foreach ($produtos as $produto)
                            <div class="bg-white rounded-3xl border border-gray-200 shadow-sm dark:bg-gray-800 dark:border-gray-700">
                                <div class="flex items-center justify-center h-[288px]">
                                    <a href="{{ route('ofertas.show', $produto->id)  }}">
                                        <img class="p-4 max-h-[288px] rounded-3xl" src="{{ asset('images/' . $produto->image)  ?  asset('images/' . $produto->image) : 'https://d10aktedg4flw1.cloudfront.net/offers/images/01J4KXVJ35AZ6T0XJKFM3H2FV3/01J4KXVJ35CKG8NS67WE7P402T.jpeg' }}" alt="Jese Leos">
                                    </a>
                                </div>
                                
                                <div class="px-5 pb-5">                     
                                    <p class="text-lg font-light text-center">{{ $produto->nome ?? 'default'}}</p>
                                    <p class="mt-3 font-light text-center text-gray-500 dark:text-gray-400">A partir de:</p>
                                    <h3 class="text-xl font-bold tracking-tight text-center text-blue-800 dark:text-gray-400">R$ {{ number_format($produto->valor / 100, 2, ',', '.') }}</h3>
                                    <p class="font-light text-center text-gray-500 dark:text-gray-400">à vista</p>
                                    <div class="mt-6 flex items-center justify-center">
                                        <a href="{{ $produto->link }}" class="inline-flex w-full justify-center rounded-md border border-transparent bg-[#24b45d] py-3 px-5 text-sm font-medium text-white shadow-sm hover:bg-[#1b8746] focus:outline-none focus:ring-2 focus:ring-[#24b45d] focus:ring-offset-2 disabled:opacity-75 cursor-pointer">Pegar Promoção
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="w-5 h-5 ml-2 -mr-1"><path fill-rule="evenodd" d="M4.25 5.5a.75.75 0 00-.75.75v8.5c0 .414.336.75.75.75h8.5a.75.75 0 00.75-.75v-4a.75.75 0 011.5 0v4A2.25 2.25 0 0112.75 17h-8.5A2.25 2.25 0 012 14.75v-8.5A2.25 2.25 0 014.25 4h5a.75.75 0 010 1.5h-5z" clip-rule="evenodd"></path><path fill-rule="evenodd" d="M6.194 12.753a.75.75 0 001.06.053L16.5 4.44v2.81a.75.75 0 001.5 0v-4.5a.75.75 0 00-.75-.75h-4.5a.75.75 0 000 1.5h2.553l-9.056 8.194a.75.75 0 00-.053 1.06z" clip-rule="evenodd"></path></svg>
                                        </a>                                        
                                    </div>
                                    
                                    <div class="text-xs mt-3 flex gap-x-2 justify-end items-center text-right">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="w-3 h-3 ml-2 -mr-1"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 
                                        há cerca de {{ $produto->created_at->setTimezone('America/Sao_Paulo')->diffForHumans() }}
                                    </div>
                                </div>
                            </div> 
                            
                        @endforeach
                        
                    </div>
                    <div class="text-xs text-gray-400 bg-white w-full p-4 fixed bottom-0"> Quando você compra por meio de links em nosso site podemos ganhar uma comissão de afiliados sem nenhum custo para você. </div>
                </div>
    
            @endif 
        </section>
    </x-oferta-layout>