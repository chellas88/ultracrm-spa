<template>
    <div>
        <div>
            <SideBar @logout="logout" v-if="token"></SideBar>
        </div>
        <div class="main">
            <Navbar :token="token"></Navbar>
            <router-view :pipelines="pipelines"></router-view>
        </div>
    </div>
</template>

<script>
import SideBar from "./components/SideBar";
import Navbar from "./components/NavBar";
export default {
    name: "Index",
    components: {
        SideBar,
        Navbar
    },
    data(){
        return {
            token: null,
            pipelines: [],
            current_pipeline: null
        }
    },
    beforeMount() {
        this.getUserInfo()
    },
    methods: {
        getToken(){
            this.token = localStorage.getItem('x_xsrf_token')
        },

        logout(){
            axios.post('/logout')
                .then(res => {
                    localStorage.removeItem('x_xsrf_token')
                    this.$router.push('/login')
                })
        },
        async getUserInfo(){
            await axios.get('/api/getUserInfo')
                .then(res => {
                    console.log(res.data)
                    this.pipelines = res.data.pipelines
                })
                .catch(err => {
                    console.log(err.response)
                })
        }
    },
    mounted() {
        this.getToken()
    },
    updated() {
        this.getToken()
    }
}
</script>

<style scoped>

</style>
