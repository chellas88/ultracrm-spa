<template>
    <div :id="id" class="popup_overlay" ref="openModal">
        <div class="modal_box">
            <i class='bx bx-x close' @click="close"></i>
            <div class="modal_header">
                <div class="modal_title">
                    <slot name="title"></slot>
                </div>

            </div>
            <div class="modal_body">
                <slot name="body"></slot>
            </div>
            <div class="modal_footer">
                <button class="btn-cancel" @click="close">Cancel</button>
                <button class="btn-ok" @click="ok">Ok</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Modal",
    props : {
        target: {
            type: String
        },
        id: {
            type: String
        }
    },
    mounted() {
        let mBtn = document.querySelectorAll('.modal');
        mBtn.forEach(el =>{
            el.addEventListener('click', () => {
                let modalId = el.getAttribute('target')
                let modal = document.getElementById(modalId)
                modal.classList.add('show')
            })
        })

    },
    methods: {
        close(){
            this.$refs.openModal.classList.remove('show')
        },
        ok(){
            this.$emit('ok')
            this.close()
        }
    }
}
</script>

<style scoped>
.popup_overlay{
    position: fixed;
    left: 0;
    top: 0;
    display: flex;
    width: 100%;
    height: 100vh;
    background: rgba(0,0,0, 0.5);
    z-index: 100;
    align-items: center;
    justify-content: center;
    pointer-events: none;
    transform: scale(1.2);
    transition: opacity 0.3s 0s ease-in-out;
    opacity: 0;
}
.popup_overlay.show{
    opacity: 1;
    pointer-events: auto;
}
.modal_box {
    position: relative;
    /*top: -10%;*/
    padding: 10px;
    max-width: 380px;
    width: 100%;
    background: #fff;
    border-radius: 12px;
    pointer-events: auto;
}
.modal_box .close{
    position: absolute;
    right: 6px;
    top: 6px;
    font-size: 24px;
    cursor: pointer;
    color: #b4b4b4;
    transition: all 0.2s ease;
    z-index: 101;
}
.modal_box .close:hover {
    color: #999696;
}
.modal_box .modal_header{
    position: relative;
    margin-bottom: 10px;
    border-bottom: 1px solid #dfdfdf;
}
.modal_header .modal_title {
    font-weight: 600;
}
.modal_box .modal_body{
    padding-bottom: 15px;
}
.modal_box .modal_footer{
    display: flex;
    justify-content: flex-end;
    padding-top: 10px;
    border-top: 1px solid #dfdfdf;
}
.modal .modal_footer{
    margin-top: 15px;
}
.modal_footer button{
    outline: none;
    border: none;
    padding: 6px 12px;
    border-radius: 6px;
    margin-left: 8px;
    color: #fff;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
}
.modal_footer .btn-cancel{
    background: #f082ac;
}
.modal_footer .btn-cancel:hover{
    background: #ec5f95;
}
.modal_footer .btn-ok{
    background: #6f93f6;
    padding: 6px 20px;
}
.modal_footer .btn-ok:hover{
    background: #275df1;
}

</style>
