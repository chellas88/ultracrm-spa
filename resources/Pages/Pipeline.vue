<template>
    <div class="px-4">
        <div class="flex flex-row bg-white rounded-md p-2 shadow-sm sm:justify-between">
            <ul class="leads-nav flex">
                <li v-if="!isKanban" @click="isKanban = !isKanban">
                    <button class="p-1 bg-slate-300 rounded-sm hover:bg-slate-200">
                        <svg class="kanban-type">
                            <use xlink:href="/icons/sprites.svg#kanban-icon"></use>
                        </svg>
                    </button>
                </li>
                <li v-if="isKanban" @click="isKanban = !isKanban">
                    <button class="p-1 bg-slate-300 rounded-sm hover:bg-slate-200">
                        <svg class="kanban-type">
                            <use xlink:href="/icons/sprites.svg#rows-icon"></use>
                        </svg>
                    </button>
                </li>
                <li>
                    <button class="modal lead-menu pr-4 bg-sky-400 rounded-sm hover:bg-teal-100" target="newLead">
<!--                        <i class='bx bx-plus'></i>-->
                        <span>New Lead</span>
                    </button>
                </li>
            </ul>

            <ul>
                <li>
<!--                    <button class="flex sm:justify-between items-center bg-slate-200 py-2 px-4 w-40" :pipeline="pipelineId">-->
<!--                        <span>{{ pipelineName }}</span>-->
<!--                        <i class='bx bx-chevron-down' ></i>-->
<!--                    </button>-->
                </li>
            </ul>
        </div>
        <div v-for="pip in pipelines" :key="pip.id">
            <button @click="current_pipeline = pip.id">{{ pip.name }}</button>
        </div>
        <Kanban
            :stages="stages"
        >

        </Kanban>
    </div>
</template>

<script>
import Kanban from "../js/components/Pipeline/Kanban";
export default {
    name: "Pipeline",
    components: {
        Kanban
    },
    props: {
        pipelines: Array
    },
    data(){
        return {
            isKanban: true,
            stages: [],
            current_pipeline: null,
            pipelineName: '',
            pipelineId: ''
        }
    },
    beforeMount() {
        this.getCurrentPipeline()
        // setTimeout(()=>{
            this.getPipeline()
        // }, 1000)

    },
    methods: {
        getCurrentPipeline(){
            let pip = localStorage.getItem('current_pipeline')
            if (pip){
                let truePipeline = false
                this.pipelines.forEach(pipeline =>{
                    if (+pipeline.id === +pip){
                        localStorage.setItem('current_pipeline', pipeline.id)
                        truePipeline = true
                    }
                })
                if (!truePipeline) {
                    localStorage.setItem('current_pipeline', this.pipelines[0].id)
                }
            }
            else {
                localStorage.setItem('current_pipeline', this.pipelines[0].id)
            }
            this.current_pipeline = localStorage.getItem('current_pipeline')
        },
        async getPipeline(){
            await axios.get('/api/pipeline/'+ this.current_pipeline)
                .then(res => {
                    console.log(res.data.data)
                    this.stages = res.data.data.stages
                    this.pipelineName = res.data.data.name
                })
                .catch(err => {
                    console.log(err.response)
                })
        }
    }
}
</script>

<style scoped>

.leads-nav button{
    height: 100%;
    border: none;
    margin-right: 5px;
    outline: none;
    transition: all 0.2s ease-in-out;
}
.leads-nav .kanban-type{
    width: 30px;
    height: 30px;
}

.leads-nav .lead-menu{
    border: none;
    height: 100%;
    display: flex;
    padding: 0px 10px;
    font-size: 16px;
    align-items: center;
    text-align: center;
    transition: all 0.2s ease-in-out;
}
.lead-menu i{
    font-size: 24px;
    margin-right: 5px;
    padding: 0;
}
</style>
