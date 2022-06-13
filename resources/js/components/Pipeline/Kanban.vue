<template>
    <div class="bg-white p-4 rounded-sm">
        <div class="kanban" id="kanban" v-dragscroll:nochilddrag>
            <div data-dragscroll class="drag-column shadow" v-for="column in stages" :key="column.id">
                <h5 data-dragscroll class="unselected" :style="{'background' : column.color}">
                    {{ column.title }} ({{ column.leads.length }})
                    <i class='bx bx-edit' ></i>
                </h5>
                <draggable class="draggable-list" :list="column.leads" group="leads" v-bind="{animation: 300} "
                           @change="checkMove($event, column.id)">
                    <div class="list-item shadow unselected grab" v-for="lead in column.leads"
                         :class="{ ondrag: grab, nodrag: !grab }"
                         @mousedown="grab = true" @mouseup="grab = false" @dragend="stopDrag()"
                         @dragstart="startDrag(lead.id)"
                         :key="lead.title" @drag="currentLead = lead.id" :id="'lead_' + lead.id">
                        <div class="lead_head mx-2"><a :href="'/lead/' + lead.id">{{ lead.title }}</a></div>
                        <div class="lead_body">
                            <div class="mx-2">
                                <label>Дата створення</label>
                                {{ lead.created_at }}
                            </div>

                            <div class="lead_contact m-2">
                                <label>Контакти</label>
                                <div v-if="!lead.contact">
                                    <a href="">Контакт не закріплено</a>
                                </div>
                                <div v-else>
                                    <a :href="'/contacts/' + lead.contact.id "><i class="link-icon mx-1"
                                                                                  data-feather="user"></i>{{
                                            lead.contact.first_name
                                        }} {{ lead.contact.last_name }}</a>
                                    <p v-if="lead.contact.phone"><img class="link-icon mx-2"
                                                                      src="/assets/icons/phone.svg">{{
                                            lead.contact.phone
                                        }}</p>
                                    <p v-if="lead.contact.email"><img class="link-icon mx-2"
                                                                      src="/assets/icons/mail.svg">{{
                                            lead.contact.email
                                        }}</p>
                                </div>
                            </div>

                            <div class="manager">
                                <label :for="'manager_' + lead.manager.id"
                                       class="d-block mx-2 mb-1">Менеджер</label>
                                <a :href="'/manager/' + lead.manager.id" :id="'manager_' + lead.manager.id">
                                    <img v-if="lead.manager.avatar" :src="'/uploads/avatars/' + lead.manager.avatar"
                                         class="wd-30 ht-30 rounded-circle mx-2">
                                    <img v-else src="/assets/images/avatar.svg"
                                         class="wd-30 ht-30 rounded-circle mx-2">
                                    {{ lead.manager.name }}
                                </a>
                            </div>
<!--                        </div>-->
<!--                        <div class="lead_footer">-->

<!--                            <a href="#" data-bs-toggle="modal"-->
<!--                               data-bs-target="#removeLead"-->
<!--                               id="removeLeadBtn" @click="getLeadInfo(lead.id, lead.title)">-->
<!--                                <img src="/assets/icons/trash.svg" class="action-icon">-->
<!--                            </a>-->
                        </div>
                    </div>


                </draggable>


<!--            </div>-->
<!--            <div class="done-col">-->
<!--                <draggable :list="done" group="leads" class="done-block" @change="checkMove($event, 'done')">-->
<!--                    <img src="/assets/icons/checkmark-done.svg">{{ locale.complete_lead }}-->
<!--                </draggable>-->
            </div>


        </div>

    </div>




</template>


<script>
import draggable from "vuedraggable";

export default {
    components: {
        draggable,
    },
    props: {
        stages: {
            type: Array
        },
        pipelineList: {
            type: Array
        },
        pipeline_id: {},
        currency: {},
        managers: {},
        allLeadsShow: {}
    },
    data() {
        return {
            columns: [],
            grab: false,
            moveFrom: '',
            moveTo: '',
            currentLead: '',
            leadId: '',
            leadName: '',
            modalStageEdit: false,
            showAll: this.allLeadsShow,
            done: []
        };
    },
    methods: {
        async reloadKanban() {
            let data = {
                params: {
                    show_all: this.showAll
                }
            }
            await axios.get('/loadStages/' + this.pipeline_id, data)
                .then(response => {
                    this.columns = response.data.columns
                })
        },
        async checkMove({added, removed, moved}, col) {
            if (added) {
                this.moveTo = col;
            }
            if (removed) {
                this.moveFrom = col
            }
            if (moved) {
                for (let key in this.columns) {
                    if (this.columns[+key]['id'] === col) {
                        let data = {
                            params: {
                                data: this.columns[+key],
                                lead_id: this.currentLead
                            }
                        }
                        axios.get('/leadMove', data)
                            .then(response => {
                                this.currentLead = ''
                                this.moveFrom = ''
                            })
                    }
                }
            }
            if (this.moveTo && this.moveFrom && this.moveTo !== 'done') {
                for (let key in this.columns) {
                    if (this.columns[+key]['id'] === this.moveTo) {
                        let data = {
                            params: {
                                data: this.columns[+key],
                                lead_id: this.currentLead
                            }
                        }
                        await axios.get('/leadChangeStatus', data)
                            .then(response => {
                                this.currentLead = ''
                                this.moveFrom = ''
                            })
                    }
                }
            } else if (this.moveTo && this.moveFrom && this.moveTo === 'done') {
                let data = {
                    params: {
                        lead_id: this.currentLead,
                        last_stage: this.moveFrom
                    }
                }
                await axios.get('/leadComplete', data)
                    .then(response => {
                        console.log(response.data)
                        this.currentLead = ''
                        this.moveFrom = ''
                    })
            }
        },
        getLeadInfo: function (id, title) {
            this.leadId = id
            this.leadName = title
        },
        openStageEdit: function (e) {
            let mouseX = e.pageX
            let mouseY = e.pageY
            console.log(mouseX)
            $('.modal-stage-edit').css({position: "absolute", top: mouseY, left: mouseX});
            this.modalStageEdit = true
        },
        startDrag(lead_id) {
            this.grab = true
            document.getElementsByClassName("done-col")[0].style.display = "block"
        },
        stopDrag() {
            this.grab = false
            document.getElementsByClassName("done-col")[0].style.display = "none"
        }
    },
    // mounted() {
    //     this.reloadKanban()
    //     let th = this
    //     setInterval(function () {
    //         th.reloadKanban()
    //     }, 20000)
    //
    // },

};
</script>

<style scoped>
.icon {
    width: 18px;
}

.kanban {
    display: flex;
    overflow-x: auto;
    min-height: 70vh;
    cursor: move;
    position: relative;
    justify-content: space-between;
}

.kanban-menu {
    color: #726f6f;
}

.drag-column {
    min-width: 300px;
    margin-right: 20px;
    cursor: move;
    position: relative;
}

.drag-column h5 {
    font-size: 0.95rem;
    font-family: unset;
    white-space: nowrap;
    padding: 10px 5px;
    border-bottom: 1px solid #c9c9c9;
    color: #000;
    text-shadow: #cdcbcb 1px 1px 0;
}

.draggable-list {
    /*margin-top: 5px;*/
    background: #f1f1f1;
    min-height: 70vh;
    padding: 10px;
    cursor: default;
}

.list-item {
    border: 1px solid #e1e4e7;
    cursor: default !important;
    color: #000;
    font-size: 16px;
    border-radius: 5px;
    background: #f8f9fa;
    display: block;
    min-height: 150px;
    margin-bottom: 15px;
}

.ondrag {
    cursor: grabbing !important;
}

.nodrag {
    cursor: grab !important;
}

.lead_head {
    padding: 5px;
    font-size: 16px;
    font-weight: 400;
    white-space: nowrap;
    overflow: hidden;
    margin-bottom: 5px;
}

.lead_head a {
    color: #4492d7;

}

.lead_body {
    font-size: 14px;
    padding: 5px;
    position: relative;
    color: #2a2a2a;
    font-weight: 400;
}

.lead_footer {
    text-align: right;
    padding: 5px;
    background: #ededed;
    font-size: 13px;
}


.lead_body label {
    color: #9c9b9b;
    font-size: 14px;
    display: block;

}

.manager a {
    color: #2d8dc5;
    font-size: 16px;
}

.lead_contact a {
    cursor: pointer;
    font-weight: 100;
    color: #2b60a3;
    font-family: inherit;
    font-size: 16px;
    display: block;
    margin-bottom: 4px;
}

.lead_contact a:hover {
    color: #000;
}

.lead_contact svg {
    height: 18px;
}

.lead_contact img {
    height: 16px;
}

.lead_contact p {
    font-style: italic;
    color: #646060;
    font-size: 14px;
    font-weight: 100;
}

.edit-icon {
    width: 20px;
    position: absolute;
    right: 5px;
    cursor: pointer;

}

.modal-stage-edit {

}

.btn-icon {
    width: 25px;
}

.done-col {
    background: #0c7e0cad;
    padding: 18px;
    text-align: center;
    border-radius: 15px;
    position: fixed;
    right: 2px;
    bottom: 3px;
    color: #fff;
    display: none;
    animation: show 1s forwards;
}

.done-block {
    padding: 15px 45px;
    border: 3px dashed #fff;
    font-weight: 400;
    font-size: 30px;
    z-index: 99;
}

.done-block img {
    width: 40px;
    margin-right: 10px;
}

@keyframes show {
    0% {
        opacity: 0;
    }
    100% {
        opacity: 1;
    }
}

.action-icon {
    width: 20px;
}
</style>
