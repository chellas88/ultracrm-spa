<template>
    <div class="sidebar" ref="sidebar" :class="{'active' : sidebarActive}">
        <div class="logo_content">
            <div class="logo">
                <i class='bx bx-line-chart' ></i>
                <div class="logo_name">TaskManager</div>
            </div>
            <i class='bx bx-menu' id="menu" @click="toggleSidebar"></i>
        </div>
        <ul class="nav_list">
            <li>
                    <i class='bx bx-search' @click="toggleSidebar"></i>
                    <input type="text" placeholder="Search...">
            </li>
            <li>
                <router-link :to="{name: 'home'}">
                    <i class='bx bx-grid-alt' ></i>
                    <span class="links_name">Dashboard</span>
                </router-link>
                <span class="tooltip">Dashboard</span>
            </li>
            <li>
                <router-link :to="{name: 'pipeline.index'}">
                    <i class='bx bx-columns' ></i>
                    <span class="links_name">Kanban</span>
                </router-link>
                <span class="tooltip">Dashboard</span>
            </li>
            <li>
                <a href="/dashboard">
                    <i class='bx bx-user' ></i>
                    <span class="links_name">Contacts</span>
                </a>
                <span class="tooltip">Dashboard</span>
            </li>
            <li>
                <a href="/dashboard">
                    <i class='bx bx-task' ></i>
                    <span class="links_name">Tasks</span>
                </a>
                <span class="tooltip">Dashboard</span>
            </li>
            <li>
                <a href="/dashboard">
                    <i class='bx bx-cog' ></i>
                    <span class="links_name">Settings</span>
                </a>
                                <span class="tooltip">Dashboard</span>
            </li>
        </ul>

        <div class="profile_content">
            <div class="profile">
                <div class="profile_details">
                    <img src="/images/avatar.svg">
                    <div class="user_name">
                            Admin
                    </div>
                </div>
                <i class='bx bx-log-out' id="log_out" @click="logout"></i>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    components : {
    },
    data(){
        return {
            sidebarActive: false
        }
    },
    mounted(){
        this.calcWidth()
        window.addEventListener('resize', (event) => {
            this.calcWidth()

        }, true);

    },
    methods:{
        toggleSidebar(){
            this.$refs.sidebar.classList.toggle('active')
            this.calcWidth()
        },
        calcWidth(){
            let classList = this.$refs.sidebar.classList
            let main = document.querySelector('.main')
            let active = false
            classList.forEach(el => {
                if (el === 'active') active = true
            })
            if (active){
                main.style.left = '240px'
                main.style.width = window.innerWidth - 240 + 'px'
            }
            else {
                main.style.left = '78px'
                main.style.width = window.innerWidth - 78 + 'px'
            }
        },
        logout(){
            this.$emit('logout')
        }
    },


}
</script>


<style>


</style>
