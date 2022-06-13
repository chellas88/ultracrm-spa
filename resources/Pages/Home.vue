<template>
    <div>
        Home Page
        <Modal id="modalka" @ok="popup">
            <template #title>Помилка</template>
            <template #body>
                <p>Сервіс тимчасово не доступний</p>
                <p>Спробуйте пізніше</p>
            </template>
        </Modal>
        <button class="modal" target="modalka">Open</button>

        <Modal id="modalka2">modal 2</Modal>
        <button class="modal" target="modalka2">Open 2</button>
    </div>
</template>

<script>
import Modal from "../js/components/UI/Modal";
export default {
    name: "Home",
    components: {Modal},
    data(){
        return {

        }
    },
    mounted() {
        this.getUsers()
    },
    methods: {
        getUsers(){
            axios.get('/api/getUserInfo')
                .then(res => {
                    console.log(res.data)
                })
                .catch(err => {
                    console.log(err.response)
                })
        },
        popup(){
            console.log('emit is success')
        }
    }
}
</script>

<style scoped>

</style>
