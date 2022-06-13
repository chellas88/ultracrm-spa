<template>
    <div v-if="token" class="flex flex-row p-4 mb-4 bg-gradient-to-r from-cyan-900 to-cyan-800 shadow-sm text-grey-200">
        <div class="basis-3/4 nav-links">
            <router-link :to="{name: 'home'}">Dashboard</router-link>

        </div>
        <div class="basis-1/4 auth text-right">
            <router-link v-if="!token" :to=" {name: 'login'} " class="text-sm underline">Login</router-link>
            <a href="#" v-if="token" @click="logout" class="py-2 px-5 bg-slate-200 hover:bg-slate-100 rounded-md text-slate-700
               ease-in duration-300"
            >Вийти</a>


        </div>
    </div>
</template>

<script>

export default {
    props: {
        token: {}
    },
    components: {

    },
    methods:{
        logout() {
            axios.post('/logout')
                .then(res => {
                    localStorage.removeItem('x_xsrf_token')
                    this.$router.push({name: 'login'})
                })
        }
    }
}
</script>
<style scoped>
.brand a {
    font-weight: 800;
    font-size: 1.4em;
}
.brand a span {
    font-weight: 100;
    color: #262626;
}
</style>
