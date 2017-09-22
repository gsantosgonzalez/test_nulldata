<template>
	<div class="container">
        <div class="row main">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <h2>Empleados</h2>
                    </div>
                    <div class="pull-right">
                        <button type="button" class="btn btn-primary">
                            Registrar
                        </button>
                    </div>
                </div>
            </div>
        </div> <!-- row-main -->
    </div> <!-- container -->   
</template>

<script>
    export default {
        data() {
            return {
            	employees: [],
                addresses: [],
                newEmployee: {
                    'name': '',
                    'email': '',
                    'birthdate': '',
                    'addresses': [],
                },
                newAdress: {
                    'alias': '',
                    'address': ''
                },
                updatedEmployee: {
                    'name': '',
                    'email': '',
                    'birthdate': '',
                    'addresses': [],
                },
                updatedAdress: {
                    'alias': '',
                    'address': ''
                },
                formErrors:{},
                formErrorsUpdate:{},
                showedEmployee: {
                    'name': '',
                    'email': '',
                    'birthdate': '',
                    'addresses': [],
                },                
                showedAdress: {
                    'alias': '',
                    'address': ''
                },
            }
        },
        mounted() {
            console.log('hola')
            /*axios.get('getEmployees').then(response => {
                $.each(response.data, (index, value) => {
                    this.employees.push(value);
                })
            });*/
        },
        methods: {
            getEmployees(){
                this.employees = [];
                axios.get('getEmployees').then(response => {
                    $.each(response.data, (index, value) => {
                        this.employees.push(value);
                    })
                });
            },
            showEmployee(employee){
                this.showedEmployee = employee;
            },
            registerEmployee() {
                var self = this;
                var input = this.newEmployee;
                axios
                .post('/employees', input)
                .then( function(response) {
                    if(response.data.status == 1) {
                        toastr.success( 'Se almacenó correctamente.', '¡Éxito!', { timeOut: 5000 } );
                        self.newEmployee = { 'name': '', 'email': '', 'birthdate': '', 'addreses': [] };
                        self.getEmployees();
                        $('#create-employee').modal('hide');
                    }
                    else {
                        toastr.error( 'Debes rellenar todos los campos.', '¡Error!', { timeOut: 5000 } );
                        self.formErrors = response.data.errors;
                        setTimeout(function() { self.formErrors = {}; }, 3000);
                    }
                });
            },
            editEmployee(employee){
                this.updatedEmployee.id = employee.id;
                this.updatedEmployee.name = employee.name;
                this.updatedEmployee.email = employee.email;
                this.updatedEmployee.birthdate = employee.birthdate;
            },
            updateEmployee(id) {
                var self = this;
                var input = this.updatedEmployee;
                axios
                .post('/employees/update', {
                    id: id,
                    input: input,
                })
                .then( function(response) {
                    if(response.data.status == 1) {
                        toastr.success( 'Se actualizó correctamente.', '¡Éxito!', { timeOut: 5000 } );
                        self.updatedEmployee = { 'id': '', 'name': '', 'email': '', 'birthdate': '', 'adresses': [] };
                        self.getEmployees();
                        $('#edit-employee').modal('hide');
                    }
                    else {
                        toastr.error( 'Debes rellenar todos los campos.', '¡Error!', { timeOut: 5000 } );
                        self.formErrorsUpdate = response.data.errors;
                        setTimeout(function() { self.formErrorsUpdate = {}; }, 3000);
                    }
                });
            },
            deleteEmployee(employee){
                let employee_id = $('button.btn-warning').val()
                console.log(employee_id)
            },
            cierraModal(modal){
                $('#'+modal).modal('hide');
                this.newEmployee = { 'name': '', 'email': '', 'birthdate': '', 'adresses': [] };
                this.updatedEmployee = { 'id': '', 'name': '', 'email': '', 'birthdate': '', 'adresses': [] };
                this.formErrors = {};
                this.formErrorsUpdate = {};
            }
        }
    }
</script>