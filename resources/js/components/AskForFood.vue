<template>
    <div>
        <div class="text-center" v-if="isSending">
            <i class="fas fa-spinner fa-pulse text-primary fa-5x"></i>
        </div>
        <div class="text-center" v-else-if="!confirmed">
            <h3>¿Comerás {{day}}?</h3>
            <b-button variant="success" @click="confirm">Confirmar</b-button>
        </div>
        <div class="text-center" v-else>
            <h3>Confirmaste comer {{day}}</h3>
        </div>

        <i class="fas fa-spinner fa-pulse text-primary fa-5x" style="position:fixed; top:-100%"></i>
    </div>
</template>

<script>
export default {
    props:{
        day:{
            type:String
        },
        confirmed:{
            type:Boolean
        }
    },
    data(){
        return {
            isSending:false
        }
    },
    methods:{
        confirm(){
            if(!this.isSending && !this.confirmed){
                this.isSending = true;

                axios.post(`/foods/confirm`, {
                    
                })
                .then((response) => {
                    if(response.status==200){
                        this.confirmed = true;
                    }
                    this.isSending=false
                })
                .catch((error) => {
                    this.isSending=false
                });
            }
        }
    }
}
</script>
