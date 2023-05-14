<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Tenant ID: {{tenant}}</div>

                    <div class="card-body">
                        {{message}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            tenant: String,
            message: String,
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
