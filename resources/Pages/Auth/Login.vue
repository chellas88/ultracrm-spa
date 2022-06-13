<template>
    <div class="w-full flex justify-center">
        <div class="login-block bg-blue-900 p-4 rounded-lg mt-[10%]">
            <form @submit.prevent="login">
                <h1 class="text-gray-400 text-slate-200 mb-4 text-2xl">Авторизація</h1>
                <label for="email" class="text-slate-100 p-1">Email:</label>
                <input id="email" type="email" placeholder="email@example.com"
                       class="w-full mb-4 bg-blue-800 p-2 focus:bg-blue-700 focus:outline-none text-white"
                       v-model="email">
                <p><span class="text-red-200" v-if="errors.email ">{{errors.email[0]}}</span></p>
                <label for="password" class="text-slate-100 p-1">Пароль:</label>
                <input id="password" type="password" placeholder="password"
                       class="w-full mb-4 bg-blue-800 p-2 focus:bg-blue-700 focus:outline-none text-white"
                       v-model="password">
                <span class="text-red-200" v-if="errors.password ">{{errors.password[0]}}</span>
                <button class="bg-blue-800 text-slate-200 flex mx-auto px-6 py-2 rounded-md hover:bg-blue-700"
                        :disabled="onSubmit"
                        @click="login" value="Авторизуватись">Авторизуватись</button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: "Login",
    data() {
        return {
            email: '',
            password: '',
            onSubmit: false,
            errors: Object
        }
    },
    methods: {
        login() {
            this.onSubmit = true
            let data = {
                email: this.email,
                password: this.password
            }
            axios.get('/sanctum/csrm-cookie')
                .then(response => {
                    axios.post('/login', data)
                        .then(r => {
                            localStorage.setItem('x_xsrf_token', r.config.headers['X-XSRF-TOKEN'])
                            this.onSubmit = false
                            console.log(r)
                            this.$router.push({name: 'home'})
                        })
                        .catch(err => {
                            if (err.response.data.errors){
                                this.errors = err.response.data.errors
                            }
                            this.onSubmit = false
                        })
                })
        }
    }
}
</script>

<style scoped>

</style>
