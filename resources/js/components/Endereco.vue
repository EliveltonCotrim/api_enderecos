<template>
    <nav-component title="Endereços">
        <slot>
            <input class="form-control me-2" type="text" placeholder="Pesquisar" aria-label="Pesquisar" v-model="search"
                @keyup="searchCep()">
        </slot>
    </nav-component>

    <!-- modal create -->
    <modal-component id="modalCreate" title="Cadastrar Endereço">
        <template v-slot:alerts>
            <alert-component tipo="success" :detalhes="transacaoDetalhes" v-if="statusAlertSuccess"
                title="Cadastrado realizado com sucesso"></alert-component>

            <alert-component tipo="danger" :detalhes="transacaoDetalhes" title="Erro ao tentar cadastrar o endereço"
                v-if="statusAlertError"></alert-component>
        </template>
        <template v-slot:content>
            <input-container-component title="Cep" id="idCep">
                <vue-mask type="text" class="form-control" id="cep" mask="00000-000" :raw="false" placeholder="00000-000"
                    v-model="createEndereco.cep" @blur="buscarCep()">
                </vue-mask>
            </input-container-component>
            <input-container-component title="Logradouro" id="idLogradouro">
                <input type="text" class="form-control" id="idLogradouro" placeholder=""
                    v-model="createEndereco.logradouro">
            </input-container-component>
            <input-container-component title="Bairro" id="idbairro">
                <input type="text" class="form-control" id="idbairro" placeholder="" v-model="createEndereco.bairro">
            </input-container-component>
            <input-container-component title="Cidade" id="idCidade">
                <input type="text" class="form-control" id="idCidade" placeholder="" v-model="createEndereco.cidade">
            </input-container-component>
            <input-container-component title="UF" id="idUf">
                <input type="text" class="form-control" id="idUf" placeholder="" v-model="createEndereco.uf">
            </input-container-component>
        </template>
        <template v-slot:footer>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="resetInputs()">
                Cancelar
            </button>
            <button type="button" class="btn btn-primary" @click="salvar()">Salvar e cadastrar outro</button>
            <button type="button" class="btn btn-success" @click="salvar('close')">Salvar</button>
        </template>
    </modal-component>
    <!-- end modal create -->

    <!-- modal edit -->
    <modal-component id="modalEdit" title="Editar Endereço">
        <template v-slot:alerts>
            <alert-component tipo="success" :detalhes="transacaoDetalhes" v-if="statusAlertSuccess"
                title="Cadastrado realizado com sucesso"></alert-component>
            <alert-component tipo="danger" :detalhes="transacaoDetalhes" title="Erro ao tentar editar o endereço"
                v-if="statusAlertError"></alert-component>
        </template>
        <template v-slot:content>
            <input-container-component title="Cep" id="idCep">
                <input type="text" class="form-control" id="cep" placeholder="00000-000" v-model="editEndereco.cep">
            </input-container-component>
            <input-container-component title="Logradouro" id="idLogradouro">
                <input type="text" class="form-control" id="idLogradouro" placeholder="" v-model="editEndereco.logradouro">
            </input-container-component>
            <input-container-component title="Bairro" id="idbairro">
                <input type="text" class="form-control" id="idbairro" placeholder="" v-model="editEndereco.bairro">
            </input-container-component>
            <input-container-component title="Cidade" id="idCidade">
                <input type="text" class="form-control" id="idCidade" placeholder="" v-model="editEndereco.cidade">
            </input-container-component>
            <input-container-component title="UF" id="idUf">
                <input type="text" class="form-control" id="idUf" placeholder="" v-model="editEndereco.uf">
            </input-container-component>
        </template>
        <template v-slot:footer>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="resetInputsEdit()">
                Cancelar
            </button>
            <button type="button" class="btn btn-primary" @click="updateCep('close')">Salvar</button>
        </template>
    </modal-component>
    <!-- end modal edit -->

    <!-- modal delete -->
    <modal-component id="modalDelete" title="Confirmação">
        <template v-slot:alerts>
            <alert-component tipo="success" :detalhes="transacaoDetalhes" v-if="statusAlertSuccess"
                title="Cadastrado realizado com sucesso"></alert-component>

            <alert-component tipo="danger" :detalhes="transacaoDetalhes" title="Erro ao tentar cadastrar o endereço"
                v-if="statusAlertError"></alert-component>
        </template>
        <template v-slot:content>
            <p>Deseja realmente excluir o CEP: <strong>{{ deleteEndereco.cep }}</strong>?</p>
        </template>
        <template v-slot:footer>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="resetInputs()">
                Cancelar
            </button>
            <button type="button" class="btn btn-danger" @click="destroyCep('close')">Excluir</button>
        </template>
    </modal-component>
    <!-- end modal delete -->
    <!-- card endereço -->
    <div class="container mt-3 mb-5">
        <button class="btn btn-success mb-3 btn-sm" data-bs-toggle="modal" data-bs-target="#modalCreate">Novo
            Endereço</button>

        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-sm-2 g-4">
            <card-component v-for="(cep, key ) in ceps" :key="key">
                <slot>
                    <!-- <h6 class="card-subtitle mb-2 text-body-secondary">{{ cep.logradouro }}</h6> -->
                    <h5 class="card-title">CEP: {{ cep.cep }}</h5>
                    <p class="card-text mb-0">{{ cep.logradouro }}</p>
                    <p class="card-text mb-0">{{ cep.bairro }}</p>
                    <p class="card-text mb-0">{{ cep.cidade }}</p>
                    <p class="card-text">{{ cep.uf }}</p>
                    <button type="button" class="btn btn-primary me-1 btn-sm" data-bs-toggle="modal"
                        data-bs-target="#modalEdit" @click="editCep(cep.id)">
                        <fa icon="pen-to-square"></fa>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalDelete"
                        @click="deleteCep(cep.cep, cep.id)">
                        <fa icon="trash-can"></fa>
                    </button>
                </slot>
            </card-component>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Alert from './Alert.vue';
import { useToast } from 'vue-toastification';

export default {
    components: { Alert },
    setup() {
        const toast = useToast();

        return { toast }
    },
    data() {
        return {
            editEndereco: {
                id: '',
                cep: '',
                logradouro: '',
                bairro: '',
                cidade: '',
                uf: '',
                errors: {}
            },
            deleteEndereco: {
                id: '',
                cep: '',
            },
            createEndereco: {
                cep: '',
                logradouro: '',
                bairro: '',
                cidade: '',
                uf: '',
            },
            urlBase: 'http://localhost/teste-vaga/public/api/buscar-endereco/',
            statusAlertSuccess: false,
            statusAlertError: false,
            showModal: false,
            transacaoDetalhes: {},
            ceps: [],
            search: '',

        }
    },
    mounted() {
        this.getCeps()
    },
    methods: {
        resetInputs() {
            this.createEndereco.cep = ''
            this.createEndereco.cepDelete = ''
            this.createEndereco.logradouro = ''
            this.createEndereco.bairro = ''
            this.createEndereco.cidade = ''
            this.createEndereco.uf = ''
            this.createEndereco.idCep = ''
        },
        searchCep() {

            console.log(this.search)
            let config = {
                headers: {
                    'Accept': 'application/json'
                }
            }
            axios.get('http://localhost/teste-vaga/public/api/endereco?search=' + this.search, config)
                .then(response => {
                    this.ceps = response.data
                })
                .catch(error => {
                    console.log(error)
                })
        },
        resetInputsEdit() {
            this.editEndereco.cep = ''
            this.editEndereco.logradouro = ''
            this.editEndereco.bairro = ''
            this.editEndereco.cidade = ''
            this.editEndereco.uf = ''
            this.editEndereco.id = ''
            this.editEndereco.errors = {}
        },
        resetInputsDelete() {
            this.deleteEndereco.cep = ''
            this.deleteEndereco.id = ''
        },
        hideAlert(new_val) {
            if (new_val) {
                setTimeout(() => {
                    this.statusAlertSuccess = false;
                    this.statusAlertError = false;
                }, 8000)
            }
        },
        deleteCep(cep, id) {

            this.deleteEndereco.cep = cep
            this.deleteEndereco.id = id
        },
        destroyCep(acao) {
            let config = {
                headers: {
                    'Accept': 'application/json'
                }
            }
            console.log(this.idCep)

            axios.delete('http://localhost/teste-vaga/public/api/endereco/' + this.deleteEndereco.id, config)
                .then(response => {
                    this.toast.success('CEP: ' + this.deleteEndereco.cep + ' excluído com sucesso!', {
                        timeout: 5000,
                    });

                    this.getCeps()
                    this.resetInputsDelete()

                    if (acao == 'close') {
                        $('#modalDelete').modal('hide')
                    }
                })
                .catch(error => {
                    console.log(error)
                })
        },
        editCep(id) {
            let config = {
                headers: {
                    'Accept': 'application/json'
                }
            }

            axios.get('http://localhost/teste-vaga/public/api/endereco/' + id, config)
                .then(response => {
                    this.statusAlertError = false;

                    this.editEndereco.cep = response.data.cep
                    this.editEndereco.logradouro = response.data.logradouro
                    this.editEndereco.bairro = response.data.bairro
                    this.editEndereco.cidade = response.data.cidade
                    this.editEndereco.uf = response.data.uf
                    this.editEndereco.id = response.data.id

                })
                .catch(error => {
                    console.log(error)
                })
        },
        updateCep(acao) {

            this.editEndereco.errors = {};

            if (!this.editEndereco.cep) {
                this.editEndereco.errors.cep = ["O campo CEP é obrigatório."];
            }

            if (!this.editEndereco.logradouro) {
                this.editEndereco.errors.logradouro = ['O campo Logradouro é obrigatório.'];
            }

            if (!this.editEndereco.bairro) {
                this.editEndereco.errors.bairro = ['O campo Bairro é obrigatório.'];
            }

            if (!this.editEndereco.cidade) {
                this.editEndereco.errors.cidade = ['O campo Cidade é obrigatório.'];
            }

            if (!this.editEndereco.uf) {
                this.editEndereco.errors.uf = ['O campo UF é obrigatório.'];
            }

            if (Object.keys(this.editEndereco.errors).length === 0) {
                localStorage.setItem('editEndereco', JSON.stringify(this.editEndereco))

                if (acao == 'close') {

                    $('#modalEdit').modal('hide')
                }

                this.toast.success('Endereço atualizado com sucesso!', {
                    timeout: 5000,
                });

                this.resetInputsEdit();
                this.getCeps()

            } else {

                console.log(this.editEndereco.errors)
                this.statusAlertError = true
                this.transacaoDetalhes = {
                    // mensagem: error.response.data.message,
                    dados: this.editEndereco.errors
                }

                this.hideAlert(this.statusAlertError)

            }

        },
        salvar(acao) {
            console.log(acao)
            let config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'Accept': 'application/json',

                }
            }

            let formData = new FormData()
            formData.append('cep', this.createEndereco.cep)
            formData.append('logradouro', this.createEndereco.logradouro)
            formData.append('bairro', this.createEndereco.bairro)
            formData.append('cidade', this.createEndereco.cidade)
            formData.append('uf', this.createEndereco.uf)

            axios.post('http://localhost/teste-vaga/public/api/endereco', formData, config)
                .then(response => {

                    if (acao == 'close') {

                        $('#modalCreate').modal('hide')
                    }

                    this.toast.success('CEP: ' + response.data.cep + ' cadastrado com sucesso!', {
                        timeout: 5000,
                    });

                    this.resetInputs();
                    this.getCeps()

                })
                .catch(error => {
                    this.statusAlertError = true
                    this.transacaoDetalhes = {
                        // mensagem: error.response.data.message,
                        dados: error.response.data.errors
                    }

                    this.hideAlert(this.statusAlertError)
                })
        },
        buscarCep() {

            let config = {
                headers: {
                    'Accept': 'application/json'
                }
            }

            console.log(this.createEndereco.cep)

            axios.get(this.urlBase + this.createEndereco.cep, config)
                .then(response => {

                    let retorno = response.data

                    this.createEndereco.logradouro = retorno.data.logradouro
                    this.createEndereco.bairro = retorno.data.bairro
                    this.createEndereco.cidade = retorno.data.cidade
                    this.createEndereco.uf = retorno.data.uf

                })
                .catch(error => {
                    console.log(error)
                })
        },
        getCeps() {
            let config = {
                headers: {
                    'Accept': 'application/json'
                }
            }
            axios.get('http://localhost/teste-vaga/public/api/endereco', config)
                .then(response => {
                    this.ceps = response.data
                })
                .catch(error => {
                    console.log(error)
                })
        }
    }
}
</script>

<style></style>
