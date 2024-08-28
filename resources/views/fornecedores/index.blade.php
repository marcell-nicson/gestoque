<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Listagem de fornecedores') }}
        </h2>

    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> 
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">

                    @if(count($fornecedores) == 0)                            
                        <div class="flex justify-center py-4">
                            <span class="text-black dark:text-gray-600">{{ __('Nenhum fornecedor Cadastrado!') }}</span>
                        </div>
                        <div class="flex justify-center py-4" >
                            <button data-modal-target="createFornecedorModal" data-modal-toggle="createFornecedorModal"  type="button" icon="fa-solid fa-magnifying-glass mr-2" class="'w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700'">
                                <svg class="w-[20px] h-[20px] mr-2 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>  
                                {{ __('Fornecedor') }}
                            </button> 
                        </div>
                    @else
                        <div class="border-b dark:border-gray-700 mx-4">
                            <div class="flex flex-col-reverse md:flex-row items-center justify-between md:space-x-4 py-3">
                                <div class="w-full lg:w-2/3 flex flex-col space-y-3 md:space-y-0 md:flex-row md:items-center">
                                    <x-filter :action="route('fornecedores.index')" :filterFields="['name']" />

                                </div>
                                <div class="w-full md:w-auto flex flex-col md:flex-row mb-3 md:mb-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                                    <div class="flex items-center space-x-3 w-full md:w-auto">
                                        <button data-modal-target="createFornecedorModal" data-modal-toggle="createFornecedorModal"  type="button" icon="fa-solid fa-magnifying-glass mr-2" class="'w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700'">
                                            <svg class="w-[20px] h-[20px] mr-2 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                            </svg>  
                                            {{ __('Fornecedor') }}
                                        </button>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="p-4">
                                            <div class="flex items-center">
                                                <input id="checkbox-all" type="checkbox" class="w-4 h-4 text-primary-600 bg-gray-100 rounded border-gray-300 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="checkbox-all" class="sr-only">checkbox</label>
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center">Nome</th>
                                        <th scope="col" class="px-6 py-3 text-center">Status</th>
                                        <th scope="col" class="px-6 py-3 text-center">Quantidade do Estoque</th>
                                        <th scope="col" class="px-6 py-3 text-center">whatsapp</th>
                                        <th scope="col" class="px-6 py-3 text-center">E-mail</th>
                                        <th scope="col" class="px-6 py-3 text-center"></th>
                                        <th scope="col" class="px-6 py-3 text-center"></th>                                        <th></th>
                                        <th scope="col" class="px-6 py-3 text-center"></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fornecedores as $fornecedor)                                           
                                                                    
                                        <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <td class="px-4 py-2 w-4">
                                                <div class="flex items-center">
                                                    <input id="checkbox-table-search-1" type="checkbox" onclick="event.stopPropagation()" class="w-4 h-4 text-primary-600 bg-gray-100 rounded border-gray-300 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                    <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                                </div>
                                            </td>
                                            
                                            <th scope="row" class="px-4 py-2 font-medium text-center text-gray-900 whitespace-nowrap dark:text-white">{{ $fornecedor->nome }}</th>
                                            <td class="px-4 py-2 whitespace-nowrap text-center">
                                                @if ($fornecedor->status == 'ativo')                                                            
                                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">{{$fornecedor->status}}</span>
                                                @elseif($fornecedor->status == 'Inativo')
                                                    <span class="bg-primary-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">{{$fornecedor->status}}</span>
                                                @else
                                                    <span class="bg-green-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">{{$fornecedor->status}}</span>
                                                @endif
                                            </td>
                                            {{-- <td class="px-4 py-2 whitespace-nowrap">
                                                <div class="flex -space-x-4 w-28">
                                                    @foreach ($dados['produtos'] as $produto)
                                                        <img title="{{$produto['nome']}}" src="{{ asset('images/' . $produto['image']) }}" alt="" class="w-10 h-10 flex-shrink-0 border-2 border-white rounded-full dark:border-gray-800">
                                                    @endforeach                                                            
                                                        <a href="#" class="flex-shrink-0 flex items-center justify-center w-10 h-10 text-xs font-medium text-white bg-gray-900 dark:bg-gray-700 border-2 border-white rounded-full hover:bg-gray-600 dark:border-gray-800">+5</a>
                                                </div>
                                            </td> --}}
                                            {{-- Barra de Porcentagem gradual --}}
                                            <td class="px-4 py-2 font-medium whitespace-nowrap">
                                                <div class="flex justify-end mb-1">
                                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ $fornecedor->porcentagem.'%' >= '100%' ? '100%' : '0%' }}</span>                           
                                                </div>
                                                <div class="w-full bg-gray-200 rounded-full h-1.5 dark:bg-gray-700">
                                                    @if ($fornecedor->porcentagem >= '100')
                                                        <div class="bg-green-500 h-1.5 rounded-full" style="width: {{$fornecedor->porcentagem.'%'}} >= 100 ? '100%' : '0%'"></div>
                                                    @elseif($fornecedor->porcentagem >= '50')
                                                        <div class="bg-primary-600 h-1.5 rounded-full" style="width: {{$fornecedor->porcentagem.'%'}}"></div>
                                                    @elseif ($fornecedor->porcentagem >= '20')
                                                        <div class="bg-yellow-300 h-1.5 rounded-full" style="width: {{$fornecedor->porcentagem.'%'}}"></div>
                                                    @else
                                                        <div class="bg-red-600 h-1.5 rounded-full" style="width: {{$fornecedor->porcentagem.'%'}}"></div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td title="{{ $fornecedor->contato->whatsapp }}" class="text-center px-4 py-2 text-gray-900 whitespace-nowrap dark:text-white">
                                                <a href="#" class="text-xs font-medium text-primary-600 dark:text-primary-500 hover:underline inline-flex items-center">
                                                    {{ $fornecedor->contato->whatsapp }}
                                                </a>                                                
                                            </td>
                                            <td title="{{ $fornecedor->contato->email }}" class="text-center px-4 py-2 text-gray-900 whitespace-nowrap dark:text-white">
                                                <a href="#" class="font-medium text-primary-600 dark:text-primary-500 hover:underline inline-flex items-center">
                                                    {{ $fornecedor->contato->email }}
                                                </a>                                                   
                                            </td>                                      
                                            <td title="Entradas" class="w-4 px-1 py-2 text-gray-900 whitespace-nowrap dark:text-white">
                                                <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"  class="flex items-center text-primary-700 hover:text-white border border-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-3 text-center dark:border-primary-500 dark:text-primary-500 dark:hover:text-white dark:hover:bg-primary-600 dark:focus:ring-primary-900 py-2" type="button">
                                                    <svg class="w-[16px] h-[16px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.1" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                    </svg>  
                                                </button>
                                            </td>
                                            <td class="w-4 px-1 py-2 text-gray-900 whitespace-nowrap dark:text-white">
                                                <button data-modal-target="editFornecedorModal" data-modal-toggle="editFornecedorModal" class="flex items-center text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-3 text-center dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-900 py-2" type="button">
                                                    <svg class="w-[16] h-[16px]  text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"  fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                        d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                                    </svg>
                                                </button>
                                            </td> 
                                            <td class="w-4 px-1 py-2 ">
                                                <button title="Excluir Fornecedor" data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="flex items-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-3 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900 py-2" type="button">
                                                    <svg class="w-[16] h-[16px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"  fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                                    </svg>
                                                </button>
                                            </td> 
                                            <td class="w-4 px-1 py-2">
                                                <a title="Visualizar Fornecedor" href="{{ route('fornecedores.show', $fornecedor->id)  }}" class="flex items-center text-white-700 hover:text-white border border-white-700 hover:bg-white-800 focus:ring-4 focus:outline-none focus:ring-white-300 font-medium rounded-lg text-sm px-3 text-center dark:border-white-500 dark:text-white-500 dark:hover:text-white dark:hover:bg-white-600 dark:focus:ring-primary-900 py-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg"aria-hidden="true" viewbox="0 0 24 24" fill="currentColor" class="w-[16] h-[16px]">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" />
                                                        <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                                    </svg>                                              
                                                </a>                                                                                                                    
                                            </td>
                                            <td class="w-3 py-2"></td>                                                  
                                        </tr>
                                        {{-- modal de editar --}}
                                        <div id="editFornecedorModal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 items-center justify-center overflow-y-auto overflow-x-hidden">
                                            <div class="relative w-full max-w-lg max-h-full p-4">
                                                <!-- Modal content -->
                                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 overflow-y-auto max-h-[90vh]">
                                                    <!-- Modal header -->
                                                    <div class="flex justify-between items-center p-4 border-b rounded-t dark:border-gray-600">
                                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                            Editar Fornecedor
                                                        </h3>
                                                        <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" 
                                                            data-modal-toggle="editFornecedorModal">
                                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                            </svg>
                                                            <span class="sr-only">Fechar modal</span>
                                                        </button>
                                                    </div>
                                                    <!-- Modal body -->
                                                    <div class="p-6">
                                                        <form method="POST" action="{{ route('fornecedores.update', $fornecedor->id) }}" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="grid gap-4 mb-4 md:gap-6 md:grid-cols-2 sm:mb-8">
                                                                <div>
                                                                    <label for="nome" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nome</label>
                                                                    <input type="text" name="nome" id="nome" value="{{ $fornecedor->nome }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Nome" required="">
                                                                </div>
                                                                <div>
                                                                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                                                    <input type="email" name="email" id="email" value="{{ $fornecedor->contato->email }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="email@exemplo.com" required="">
                                                                </div>
                                                                <div>
                                                                    <label for="telefone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Telefone</label>
                                                                    <input type="tel" name="telefone" id="telefone" value="{{ $fornecedor->contato->telefone }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Telefone" required="">
                                                                </div>
                                                                <div>
                                                                    <label for="whatsapp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">WhatsApp</label>
                                                                    <input type="tel" name="whatsapp" id="whatsapp" value="{{ $fornecedor->contato->whatsapp }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="WhatsApp" required="">
                                                                </div>                                            
                                                                <div>
                                                                    <label for="rua" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rua</label>
                                                                    <input type="text" name="rua" id="rua" value="{{ $fornecedor->endereco->rua }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Rua" required="">
                                                                </div>
                                                                <div >
                                                                    <label for="numero" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Número</label>
                                                                    <input type="text" name="numero" id="numero" value="{{ $fornecedor->endereco->numero }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Número" required="">
                                                                </div>
                                                                <div>
                                                                    <label for="bairro" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bairro</label>
                                                                    <input type="text" name="bairro" id="bairro" value="{{ $fornecedor->endereco->bairro }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Bairro" required="">
                                                                </div>
                                                                <div>
                                                                    <label for="cidade" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cidade</label>
                                                                    <input type="text" name="cidade" id="cidade" value="{{ $fornecedor->endereco->cidade }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Cidade" required="">
                                                                </div>
                                                                <div>
                                                                    <label for="estado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                                                                    <input type="text" name="estado" id="estado" value="{{ $fornecedor->endereco->estado }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Estado" required="">
                                                                </div>
                                                                <div>
                                                                    <label for="complemento" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Complemento</label>
                                                                    <input type="text" name="complemento" id="complemento" value="{{ $fornecedor->endereco->complemento }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Complemento">
                                                                </div>
                                                                <div>
                                                                    <label for="cep" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">CEP</label>
                                                                    <input type="text" name="cep" id="cep" value="{{ $fornecedor->endereco->cep }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="CEP" required="">
                                                                </div>
                                                            </div>
                                                            <div class="flex justify-end">                                        
                                                                <button type="submit" class="ml-3 inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                                                                    Salvar
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>        
                                        </div> 
                                        
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Main modal -->
                            <div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black bg-opacity-50">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <!-- Modal header -->
                                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                Nova Entrada
                                            </h3>
                                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" 
                                                data-modal-toggle="crud-modal">
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
                                                        @foreach ($produtos as $produto)
                                                            <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
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

                            <div id="popup-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black bg-opacity-30">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" 
                                            data-modal-toggle="popup-modal">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                        <form method="POST" action="{{ route('fornecedores.destroy', $fornecedor->id) }}" class="p-6">
                                            @csrf
                                            @method('delete')
                                            <div class="p-4 md:p-5 text-center">
                                                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                </svg>
                                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Deseja realmente deletar o fornecedor {{ $fornecedor->nome }} ?</h3>
                                                <button data-modal-hide="popup-modal" type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                    Sim, deletar
                                                </button>
                                                <button data-modal-toggle="popup-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                                    Não, cancelar
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div id="createFornecedorModal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 items-center justify-center overflow-y-auto overflow-x-hidden">
                        <div class="relative w-full max-w-lg max-h-full p-4">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 overflow-y-auto max-h-[90vh]">
                                <!-- Modal header -->
                                <div class="flex justify-between items-center p-4 border-b rounded-t dark:border-gray-600">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        Adicionar Fornecedor
                                    </h3>
                                    <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" 
                                        data-modal-toggle="createFornecedorModal">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="p-6">
                                    <form method="POST" action="{{ route('fornecedores.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="grid gap-4 mb-4 md:gap-6 md:grid-cols-2 sm:mb-8">
                                            <div>
                                                <label for="nome" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nome</label>
                                                <input type="text" name="nome" id="nome" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Nome" required="">
                                            </div>
                                            <div>
                                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                                <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="email@exemplo.com" required="">
                                            </div>
                                            <div>
                                                <label for="telefone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Telefone</label>
                                                <input type="tel" name="telefone" id="telefone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Telefone" required="">
                                            </div>
                                            <div>
                                                <label for="whatsapp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">WhatsApp</label>
                                                <input type="tel" name="whatsapp" id="whatsapp" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="WhatsApp" required="">
                                            </div>                                            
                                            <div>
                                                <label for="rua" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rua</label>
                                                <input type="text" name="rua" id="rua" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Rua" required="">
                                            </div>
                                            <div >
                                                <label for="numero" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Número</label>
                                                <input type="text" name="numero" id="numero" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Número" required="">
                                            </div>
                                            <div>
                                                <label for="bairro" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bairro</label>
                                                <input type="text" name="bairro" id="bairro" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Bairro" required="">
                                            </div>
                                            <div>
                                                <label for="cidade" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cidade</label>
                                                <input type="text" name="cidade" id="cidade" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Cidade" required="">
                                            </div>
                                            <div>
                                                <label for="estado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                                                <input type="text" name="estado" id="estado" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Estado" required="">
                                            </div>
                                            <div>
                                                <label for="complemento" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Complemento</label>
                                                <input type="text" name="complemento" id="complemento" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Complemento">
                                            </div>
                                            <div>
                                                <label for="cep" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">CEP</label>
                                                <input type="text" name="cep" id="cep" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="CEP" required="">
                                            </div>
                                        </div>
                                        <div class="flex justify-end">                                        
                                            <button type="submit" class="ml-3 inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                                                Salvar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>        
                    </div>            
                </div>
            </div>
        </div>
    </div>

    
</x-app-layout>
