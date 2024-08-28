<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-center text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalhes do fornecedor') }}
        </h2>

    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> 
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    <div class="py-6 gap-8 lg:flex" >
                        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
                            <div class="gap-8 lg:flex">
                                <!-- Sidenav -->
                                <aside id="sidebar" class="hidden h-full w-80 shrink-0 overflow-y-auto border border-gray-200 bg-white p-3 shadow-sm dark:border-gray-700 dark:bg-gray-800 lg:block lg:rounded-lg">
                                    <button id="dropdownUserNameButton" data-dropdown-toggle="dropdownUserName" type="button" class="dark:hover-bg-gray-700 mb-3 flex w-full items-center justify-between rounded-lg bg-white p-2 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700" type="button">
                                    <span class="sr-only">Open user menu</span>
                                    <div class="flex w-full items-center justify-between">
                                        <div class="flex items-center">
                                        <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/jese-leos.png" class="mr-3 h-8 w-8 rounded-md" alt="Bonnie avatar" />
                                        <div class="text-left">
                                            <div class="mb-0.5 font-semibold leading-none text-gray-900 dark:text-white">{{ $fornecedor->nome }} -
                                                @if ($fornecedor->status == 'ativo')
                                                    <span class="inline-flex items-center rounded bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">
                                                        <svg class="me-1 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5" />
                                                        </svg>
                                                        Ativo
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center rounded bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-300">
                                                        <svg class="me-1 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"></path>
                                                        </svg>
                                                        Inativo
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $fornecedor->contato->email }}</div>
                                        </div>
                                        </div>
                                        <svg class="h-5 w-5 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                        </svg>
                                    </div>
                                    </button>
                                   
                                    <div class="mb-2 w-full border-y border-gray-100 dark:border-gray-700">                                     
                                    </div> 
                                    <div class="space-y-1 mb-4 w-full">
                                        @if (count($quantidadeprodutos) == 0)
                                            <dd class="text-center font-normal text-gray-500 dark:text-gray-400"> Nenhum produto cadastrado!</dd>    
                                        @else
                                            <dt class="space-y-2 font-medium text-gray-900 dark:text-white">Estoque Total:</dt>
                                            @foreach ($quantidadeprodutos as $quantidadeproduto)
                                                <dd class="font-normal text-gray-500 dark:text-gray-400"> {{ $quantidadeproduto['nome_produto'] .' : '. $quantidadeproduto['total'] }} 
                                                    <div class="flex justify-end">
                                                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ $quantidadeproduto['total'] >= '100' ? '100%' : $quantidadeproduto['total'].'%'}}</span>                           
                                                    </div>
                                                    <div class="bg-gray-200 rounded-full dark:bg-gray-700">
                                                        @if ($quantidadeproduto['total'] >= '100')
                                                            <div class="mb-2 bg-green-500 h-1.5 rounded-full" style="width: {{$quantidadeproduto['total'].'%'}} >= 100 ? '100%' : '0%'"></div>
                                                        @elseif($quantidadeproduto['total'] >= '50')
                                                            <div class="mb-2 bg-primary-600 h-1.5 rounded-full" style="width: {{$quantidadeproduto['total'].'%'}}"></div>
                                                        @elseif ($quantidadeproduto['total'] >= '20')
                                                            <div class="mb-2 bg-yellow-300 h-1.5 rounded-full" style="width: {{$quantidadeproduto['total'].'%'}}"></div>
                                                        @else
                                                            <div class="mb-2 bg-red-600 h-1.5 rounded-full" style="width: {{$quantidadeproduto['total'].'%'}}"></div>
                                                        @endif
                                                    </div> 
                                                </dd>                                                                           
                                            @endforeach
                                        @endif                                           
                                    </div> 
                      
                                    <div class="mb-4 w-full border-y border-gray-100 dark:border-gray-700">                                     
                                    </div>  
                                    <ul class="space-y-2">
                                        <div class="space-y-4 rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-600 dark:bg-gray-700">
                                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Dados do Fornecedor</h4>
                                            <dl class="space-y-1">
                                                <dt class="font-medium text-gray-900 dark:text-white">Contato:</dt>
                                                <dd class="font-normal text-gray-500 dark:text-gray-400">Telefone: {{ $fornecedor->contato->telefone }}</dd>
                                                <dd class="font-normal text-gray-500 dark:text-gray-400">Whatsapp: {{ $fornecedor->contato->whatsapp }}</dd>
                                                <dd class="font-normal text-gray-500 dark:text-gray-400">Email: {{ $fornecedor->contato->email }}</dd>
                                            </dl>
                                            <dl class="space-y-1">
                                                <dt class="font-medium text-gray-900 dark:text-white">Data de Aniversário:</dt>
                                                <dd class="flex items-center font-medium text-gray-500 dark:text-gray-400">
                                                <svg class="me-1 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z" />
                                                </svg>
                                                12 September 2024
                                                </dd>
                                            </dl>
                                            <dl class="space-y-1">
                                                <dt class="font-medium text-gray-900 dark:text-white">Endereço:</dt>
                                                <dd class="font-normal text-gray-500 dark:text-gray-400">Rua: {{ $fornecedor->endereco->rua .' - '. $fornecedor->endereco->numero}}</dd>
                                                <dd class="font-normal text-gray-500 dark:text-gray-400">Bairro: {{ $fornecedor->endereco->bairro }}</dd>
                                                <dd class="font-normal text-gray-500 dark:text-gray-400">Cidade: {{ $fornecedor->endereco->cidade .' - '. $fornecedor->endereco->estado}}</dd>
                                                <dd class="font-normal text-gray-500 dark:text-gray-400">Cep: {{ $fornecedor->endereco->cep}}</dd>
                                                <dd class="font-normal text-gray-500 dark:text-gray-400">Complemento: {{ $fornecedor->endereco->complemento }}</dd>
                                           
                                            </dl> 
                                        </div>
                                        @if ($fornecedor->observacoes)
                                            <div class="space-y-4 rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-600 dark:bg-gray-700">
                                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Observações</h4>
                                                <dl class="space-y-1">
                                                    <dd class="font-normal text-gray-500 dark:text-gray-400">{{ $fornecedor->observacoes }}</dd>                                                
                                                </dl>                                            
                                            </div>
                                        @endif
                                    </ul>
                                </aside>
                                <!-- Right content -->
                                <div class="w-full">
                                    <div class="mb-4 items-center justify-between md:flex md:space-x-4">
                                        <form class="w-full flex-1 md:max-w-md">
                                            <label for="default-search" class="sr-only text-sm font-medium text-gray-900 dark:text-white">Search</label>
                                            <div class="relative">
                                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                                    <svg aria-hidden="true" class="h-4 w-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                    </svg>
                                                </div>
                                            <input type="search" id="default-search" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 pl-10 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" placeholder="Procure pelo ID..." required="" />
                                                <button type="submit" class="absolute bottom-0 right-0 top-0 rounded-r-lg bg-primary-700 px-4 py-2 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Search</button>
                                            </div>
                                        </form>
                                
                                        <div class="mt-4 items-center space-y-4 sm:flex sm:spacFVe-x-4 sm:space-y-0 md:mt-0">
                                            <div>
                                                <button
                                                    id="filterDropdownButtonLabel2"
                                                    data-dropdown-toggle="filterDropdownButton"
                                                    type="button"
                                                    class="flex w-full items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 md:w-auto"
                                                    >
                                                    <svg class="-ms-0.5 me-1.5 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M18.796 4H5.204a1 1 0 0 0-.753 1.659l5.302 6.058a1 1 0 0 1 .247.659v4.874a.5.5 0 0 0 .2.4l3 2.25a.5.5 0 0 0 .8-.4v-7.124a1 1 0 0 1 .247-.659l5.302-6.059c.566-.646.106-1.658-.753-1.658Z" />
                                                    </svg>
                                                    Filtro
                                                    <svg class="-me-0.5 ms-1.5 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                                                    </svg>
                                                </button>
                                                <div id="filterDropdownButton" class="z-10 hidden w-36 divide-y divide-gray-100 rounded-lg bg-white shadow dark:bg-gray-700">
                                                    <ul class="p-2 text-left text-sm font-medium text-gray-500 dark:text-gray-400" aria-labelledby="filterDropdownButtonLabel">
                                                        <li>
                                                        <a href="#" class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            <span class="me-2 h-2.5 w-2.5 rounded-full bg-primary-600"></span>
                                                            Ongoing
                                                        </a>
                                                        </li>
                                                        <li>
                                                        <a href="#" class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            <span class="me-2 h-2.5 w-2.5 rounded-full bg-green-500"></span>
                                                            <span>Completed</span>
                                                        </a>
                                                        </li>
                                                        <li>
                                                        <a href="#" class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            <span class="me-2 h-2.5 w-2.5 rounded-full bg-red-500"></span>
                                                            Denied
                                                        </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>                                        
                                                                                
                                            <button data-modal-toggle="modalp" data-modal-toggle="modalp" type="button" class="ms-4 flex w-full items-center justify-center rounded-lg bg-primary-700 px-3 py-2 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300   dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 md:w-auto">
                                                <svg class="-ms-0.5 me-1.5 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9V4a1 1 0 0 0-1-1H8.914a1 1 0 0 0-.707.293L4.293 7.207A1 1 0 0 0 4 7.914V20a1 1 0 0 0 1 1h4M9 3v4a1 1 0 0 1-1 1H4m11 6v4m-2-2h4m3 0a5 5 0 1 1-10 0 5 5 0 0 1 10 0Z" />
                                                </svg>                            
                                                Adicionar nova entrada
                                            </button>
                                        </div>
                                    </div>

                                    @if (count($entradas) == 0)
                                        <div class="mb-4 px-80 rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">                                                
                                            <dt class="text-center font-normal text-gray-500 dark:text-gray-400">Nenhuma Entrada Registrada em Sistema!</dt>                                                
                                        </div>
                                    @else
                                        @foreach ($entradas as $entrada)
                                            <div class="mb-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                                                <div class="items-start justify-between border-b border-gray-100 pb-4 dark:border-gray-700 sm:flex">
                                                    <div class="mb-4 sm:mb-0">
                                                        <h3 class="dark:text-gry-400 mb-2 text-gray-500">
                                                            ID da entrada:
                                                            <a href="#" class="font-medium text-gray-900 hover:underline dark:text-white">#{{ $entrada->id ??  '#FWB1273643' }}</a>
                                                            @if ($entrada->status == 'ativo')
                                                                <span class="ms-2 inline-flex items-center rounded bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">
                                                                    <svg class="me-1 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5" />
                                                                    </svg>
                                                                    Sucesso
                                                                </span>
                                                            @else
                                                                <span class="ms-2 inline-flex items-center rounded bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-300">
                                                                    <svg class="me-1 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"></path>
                                                                    </svg>
                                                                    Cancelado
                                                                </span>
                                                            @endif
                                                        </h3>
                                                            <a href="https://pbs.twimg.com/profile_images/511899802360365056/APTfLapD_400x400.jpeg" type="button" class="inline-flex items-center font-medium text-primary-700 hover:underline dark:text-primary-500">
                                                                <svg class="me-2 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4" />
                                                                </svg>
                                                                Comprovante de Pagamento.
                                                            </a>
                                                    </div>
                                                        @if ($entrada->status != 'inativo')
                                                            <div class="space-y-4 sm:flex sm:space-x-4 sm:space-y-0">                                                     
                                                                <form action="{{ route('entradas.entradaUpdate', ['id' => $entrada->id]) }}" method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="hidden" name="status" value="inativo">
                                                                    <button type="submit" class="w-full rounded-lg bg-red-700 px-3 py-2 text-sm font-medium text-white hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 sm:w-auto">
                                                                        Cancelar Entrada
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        @endif
                                                </div>
                                                <div class="mb-4 items-center sm:flex sm:flex-wrap xl:flex">
                                                    <dl class="mt-4 flex items-center text-gray-500 dark:text-gray-400 sm:me-8">
                                                    <dt class="me-2 font-medium text-gray-900 dark:text-white">Nome do Produto:</dt>
                                                    <dd>{{ $entrada->produto->nome ?? 'default' }} </dd>
                                                    </dl>
                                                    <dl class="mt-4 flex items-center text-gray-500 dark:text-gray-400 sm:me-8">
                                                    <dt class="me-2 font-medium text-gray-900 dark:text-white">Quantidade:</dt>
                                                    <dd>{{ $entrada->quantidade }} Produtos</dd>
                                                    </dl>
                                                    <dl class="mt-4 flex items-center text-gray-500 dark:text-gray-400">
                                                    <dt class="me-2 font-medium text-gray-900 dark:text-white">Data de Fornecimento:</dt>
                                                    <dd class="flex items-center">
                                                        <span class="ms-1">{{ $entrada->created_at->format('d/m/y H:i') }} </span>
                                                    </dd>
                                                    </dl>
                                                </div>
                                                <div class="flex items-center rounded-lg bg-gray-50 px-4 py-3 text-sm text-gray-800 dark:bg-gray-700 dark:text-gray-300" role="alert">
                                                    <svg class="me-2 hidden h-4 w-4 flex-shrink-0 sm:flex" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                    </svg>
                                                    <span class="sr-only">Info</span>
                                                    <div>Entrada Atualizada:<span class="font-medium"> {{ $entrada->updated_at->format('d/m/y H:i') }}</span></div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif


                                    <div id="modalp" data-modal-target="modalp"  tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black bg-opacity-50">
                                        <div class="relative p-4 w-full max-w-md max-h-full">
                                            <!-- Modal content -->
                                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                <!-- Modal header -->
                                                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                        Nova Entrada
                                                    </h3>
                                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" 
                                                        data-modal-toggle="modalp">
                                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                        </svg>
                                                        <span class="sr-only">Close modal</span>
                                                    </button>
                                                </div>                                        
                                                <!-- Modal body -->
                                                <form method="POST" action="{{ route('entradas.entrada_create', $fornecedor->id) }}" class="p-6">
                                                    @csrf                                                
                                                    <div class="p-4 md:p-5">
                                                        <div class="grid gap-4 mb-4">
                                                            <label for="produto_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Produtos</label>
                                                            <select id="produto_id" name="produto_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                                @foreach ($produtos as $id => $nome)
                                                                    <option value="{{ $id }}">{{ $nome }}</option>
                                                                @endforeach                                                           
                                                            </select>
                                                        </div>
                                                        <div class="grid gap-4 mb-4">
                                                            <label for="quantidade" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Quantidade</label>
                                                            <input type="number" name="quantidade" id="quantidade" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="50 Unidades" required="">
                                                        </div>
                                                        <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                            <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                                            Adicionar Entrada
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <nav class="mt-6 flex items-center justify-center sm:mt-8" aria-label="Page navigation example">
                                    <ul class="flex h-8 items-center -space-x-px text-sm">
                                        <li>
                                        <a href="#" class="ms-0 flex h-8 items-center justify-center rounded-s-lg border border-e-0 border-gray-300 bg-white px-3 leading-tight text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                            <span class="sr-only">Previous</span>
                                            <svg class="h-4 w-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7" />
                                            </svg>
                                        </a>
                                        </li>
                                        <li>
                                        <a href="#" class="flex h-8 items-center justify-center border border-gray-300 bg-white px-3 leading-tight text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">1</a>
                                        </li>
                                        <li>
                                        <a href="#" class="flex h-8 items-center justify-center border border-gray-300 bg-white px-3 leading-tight text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">2</a>
                                        </li>
                                        <li>
                                        <a href="#" aria-current="page" class="z-10 flex h-8 items-center justify-center border border-primary-300 bg-primary-50 px-3 leading-tight text-primary-600 hover:bg-primary-100 hover:text-primary-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">3</a>
                                        </li>
                                        <li>
                                        <a href="#" class="flex h-8 items-center justify-center border border-gray-300 bg-white px-3 leading-tight text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">...</a>
                                        </li>
                                        <li>
                                        <a href="#" class="flex h-8 items-center justify-center border border-gray-300 bg-white px-3 leading-tight text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">100</a>
                                        </li>
                                        <li>
                                        <a href="#" class="flex h-8 items-center justify-center rounded-e-lg border border-gray-300 bg-white px-3 leading-tight text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                            <span class="sr-only">Next</span>
                                            <svg class="h-4 w-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7" />
                                            </svg>
                                        </a>
                                        </li>
                                    </ul>
                                    </nav>
                                </div>
                                </div>

                            </div>
                        </div>
                    </div>
                  
                </div>
            </div>
        </div>
    </div>

    
</x-app-layout>
