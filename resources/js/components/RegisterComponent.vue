<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                        <form @submit.prevent="login">
                            <div class="form-group row mt-3">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                                <div class="col-md-6">
                                    <input type="email" name="email" v-model="email" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row mt-3">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Email Address</label>
                                <div class="col-md-6">
                                    <input type="email" name="email" v-model="email" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row mt-3">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input type="email" name="email" v-model="email" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row mt-3">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                                <div class="col-md-6">
                                    <input type="email" name="email" v-model="email" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row mb-2">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Register</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.container {
    margin-top: 1%;
    padding: 2%;
}

</style>
