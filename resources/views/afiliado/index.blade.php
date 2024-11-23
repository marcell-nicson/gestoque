<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard do afiliado') }}
        </h2>

    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> 
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                 
                    <div class="border-b dark:border-gray-700 mx-4">
                        <div class="flex flex-col-reverse md:flex-row items-center justify-between md:space-x-4 py-3">
                            <div class="w-full lg:w-2/3 flex flex-col space-y-3 md:space-y-0 md:flex-row md:items-center">
                                {{-- <x-filter :action="route('fornecedores.index')" :filterFields="['name']" /> --}}
                            </div>
                            <div class="w-full md:w-auto flex flex-col md:flex-row mb-3 md:mb-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                                <div class="flex items-center space-x-3 w-full md:w-auto">
                                    <button data-modal-target="createGrupo" data-modal-toggle="createGrupo" icon="fa-solid fa-magnifying-glass mr-2" class="'w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700'">
                                        <svg class="w-[20px] h-[20px] mr-2 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>  
                                        {{ __('Adicionar Grupo') }}
                                    </button>
            
                                    <button data-modal-target="modalId" data-modal-toggle="modalId" class="'w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700'" type="button">
                                        <svg class="w-[20px] h-[20px] mr-2 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>  
                                        {{ __('Adicionar Contatos') }}
                                    </button>
            
                                    <button data-modal-target="createOferta" data-modal-toggle="createOferta" icon="fa-solid fa-magnifying-glass mr-2" class="'w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700'">
                                        <svg class="w-[20px] h-[20px] mr-2 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>  
                                        {{ __('Oferta') }}
                                    </button>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(count($grupos) == 0)
                        <div class="flex justify-center py-4">
                            <span class="text-black dark:text-gray-600">{{ __('Nenhum Grupo Cadastrado!') }}</span>
                        </div>
            
                    @else                
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>                                    
                                        <th scope="col" class="px-6 py-3 text-center">Nome</th>
                                        <th scope="col" class="px-6 py-3 text-center">ID do Grupo</th>
                                        <th scope="col" class="px-6 py-3 text-center">Descrição</th>
                                        <th scope="col" class="px-6 py-3 text-center"></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($grupos as $grupo)                                           
                                                                    
                                        <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">                                          
                                            
                                            <th scope="row" class="px-4 py-2 font-medium text-center text-gray-900 whitespace-nowrap dark:text-white">{{ $grupo->nome }}</th>                                        
                                        
                                            <td title="{{ $grupo->grupo_id }}" class="text-center px-4 py-2 text-gray-900 whitespace-nowrap dark:text-white">
                                                <a href="#" class="text-xs font-medium text-primary-600 dark:text-primary-500 hover:underline inline-flex items-center">
                                                    {{ $grupo->grupo_id }}
                                                </a>
                                            </td>
                                            <td title="{{ $grupo->descricao }}" class="text-center px-4 py-2 text-gray-900 whitespace-nowrap dark:text-white">
                                                <a href="#" class="font-medium text-primary-600 dark:text-primary-500 hover:underline inline-flex items-center">
                                                    {{ $grupo->descricao }}
                                                </a>                                                   
                                            </td>
                                            <td class="w-4 px-1 py-2 ">
                                                <button title="Excluir grupo" data-modal-target="popup-delete" data-modal-toggle="popup-delete" class="flex items-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-3 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900 py-2" type="button">
                                                    <svg class="w-[16] h-[16px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"  fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                                    </svg>
                                                </button>
                                            </td>
                                            <td class="w-3 py-2"></td>                                                  
                                        </tr>
                                        
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Main modal -->
                            <div id="popup-delete" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black bg-opacity-30">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" 
                                            data-modal-toggle="popup-delete">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                        <form method="POST" action="{{ route('grupos.destroy', $grupo->id) }}" class="p-6">
                                            @csrf
                                            @method('delete')
                                            <div class="p-4 md:p-5 text-center">
                                                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                </svg>
                                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Deseja realmente deletar o grupo {{ $grupo->nome }} ?</h3>
                                                <button data-modal-hide="popup-delete" type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                    Sim, deletar
                                                </button>
                                                <button data-modal-toggle="popup-delete" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                                    Não, cancelar
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div id="modalId" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 items-center justify-center overflow-y-auto overflow-x-hidden">
                        <div class="relative w-full max-w-lg max-h-full p-4">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 overflow-y-auto max-h-[90vh]">
                                <!-- Modal header -->
                                <div class="flex justify-between items-center p-4 border-b rounded-t dark:border-gray-600">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        Adicione os Ids Separados por Virgula
                                    </h3>                                
                                    <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" 
                                        data-modal-toggle="modalId">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="p-6">
                                    <form action="{{ route('afiliado.adicionarMembrosNoGrupo' ) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="grid gap-4 mb-4 sm:grid-cols-2">                                           
                                            <div class="sm:col-span-2">                                       
                                                <label for="IdGrupo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Grupos</label>
                                                <x-input-select id="IdGrupo" name="IdGrupo" required>
                                                    @foreach($selectgrupos as $id => $nome)                          
                                                        <option value="{{ $id }}">{{ $nome }}</option>
                                                    @endforeach
                                                </x-input-select>
                                            </div>
                                            <div class="sm:col-span-2">
                                                <label for="idsContatos" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ids Contatos</label>
                                                <textarea name="idsContatos" id="idsContatos" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 " placeholder="12344, 234523" ></textarea>
                                            </div>
                                        </div>
                                        <button type="submit" class="mb-2 text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                            Save
                                        </button>   
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>  

                    <div id="createOferta" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 items-center justify-center overflow-y-auto overflow-x-hidden">
                        <div class="relative w-full max-w-lg max-h-full p-4">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 overflow-y-auto max-h-[90vh]">
                                <!-- Modal header -->
                                <div class="flex justify-between items-center p-4 border-b rounded-t dark:border-gray-600">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        Nova Oferta
                                    </h3>                                
                                    <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" 
                                        data-modal-toggle="createOferta">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="p-6">
                                    <form action="{{ route('produtos.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="grid gap-4 mb-4 sm:grid-cols-2">
                                            <div class="sm:col-span-2">
                                                <label for="nome" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nome</label>
                                                <input type="text" name="nome" id="nome" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Nome do Produto" required>
                                            </div>
                                            <div>
                                                <label for="valor_original" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">De</label>
                                                <input type="text" name="valor_original" id="valor_original" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="2.300,45" >
                                            </div> 
                                            <div>
                                                <label for="valor" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Por</label>
                                                <input type="text" name="valor" id="valor" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="1.999" required>
                                            </div>                     
                                            <div class="sm:col-span-2">
                                                <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Foto do Produto</label>
                                                <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" name="image" aria-describedby="image" id="image" type="file">
                                            </div>
                                            <div class="sm:col-span-2">
                                                <label for="link" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Link</label>
                                                <input type="text" name="link" id="link" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="www.exemplo.com.br/link-externo" required>
                                            </div>                                       
                                        </div>
                                        <button type="submit" class="mb-2 text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                            Save
                                        </button>   
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>  

                    <div id="createGrupo" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 items-center justify-center overflow-y-auto overflow-x-hidden">
                        <div class="relative w-full max-w-lg max-h-full p-4">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 overflow-y-auto max-h-[90vh]">
                                <!-- Modal header -->
                                <div class="flex justify-between items-center p-4 border-b rounded-t dark:border-gray-600">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        Novo Grupo
                                    </h3>                                
                                    <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" 
                                        data-modal-toggle="createGrupo">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="p-6">
                                    <form action="{{ route('grupos.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="grid gap-4 mb-4 sm:grid-cols-2">
                                            <div>
                                                <label for="nome" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nome</label>
                                                <input type="text" name="nome" id="nome" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Nome do Grupo" required>
                                            </div>
                                            <div>
                                                <label for="grupo_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Id do Grupo</label>
                                                <input type="text" name="grupo_id" id="grupo_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Nome do Grupo" required>
                                            </div>
                                            <div class="sm:col-span-2">
                                                <label for="descricao" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descricao</label>
                                                <textarea type="text" name="descricao" id="descricao" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder=""></textarea>
                                            </div>                                       
                                        </div>
                                        <button type="submit" class="mb-2 text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                            Save
                                        </button>   
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
