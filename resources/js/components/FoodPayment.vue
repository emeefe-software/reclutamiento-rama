<template>
    <span>
        <i v-if="isPaying" class="fas fa-spinner fa-pulse text-primary"></i>
        <i v-else v-b-tooltip.hover 
            @click="pay"
            :title="payed?'Pagado':canCheckPayment?'Presiona para indicar pagado':'No pagado'" 
            :class='["food-payment", "fas", "fa-money-bill-wave", {"text-success":payed,"no-payed":!payed, "can-check-payment":canCheckPayment}]'
        ></i>
    </span>
</template>

<script>
    export default {
        data(){
            return {
                isPaying:false,
                payed:false
            }
        },
        props:{
            isPayed:{
                type: Boolean,
                default:false
            },
            id:{
                type: Number,
                required: true
            },
            canCheckPayment:{
                type: Boolean,
                default: false
            }
        },
        mounted() {
            this.payed = this.isPayed
        },
        methods:{
            pay: function(){
                if(!this.canCheckPayment){
                    return;
                }

                if(!this.isPaying && !this.payed){
                    this.isPaying = true;

                    axios.post(`/foods/${this.id}/pay`, {
                        
                    })
                    .then((response) => {
                        if(response.status==200){
                            this.payed = true;
                        }
                        this.isPaying=false
                    })
                    .catch((error) => {
                        this.isPaying=false
                    });
                }
            }
        }
    }
</script>

<style scoped>
.food-payment.no-payed.can-check-payment{
    cursor: pointer;
}
</style>