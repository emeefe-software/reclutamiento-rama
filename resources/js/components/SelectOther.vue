<template>
  <div>
    <select id="selectOther"
    class="form-control" v-bind="$attrs" v-on="$listeners" v-if="!show" v-model="selected">
      <option value=""> {{emptyText}} </option>
      <option v-for="option in theOptions">{{option}}</option>
    </select>

    <div v-if="show" class="pl-0 pr-0 pb-0">
      <b-input-group>
        <b-form-input :v-bind="$attrs" v-on="$listeners" v-model="newOption" placeholder="Nueva opción"></b-form-input>

        <b-input-group-append>

          <b-button variant="success" v-b-tooltip.hover title="Confirmar" v-on:click="confirmar">
            <i class="fa fa-check"></i> </b-button>
          <b-button variant="danger" v-b-tooltip.hover title="Cancelar" v-on:click="cancelar">
            <i class="fa fa-times"></i> </b-button>
        </b-input-group-append>
      </b-input-group>
    </div>

  </div>
</template>

<script>
  export default {
    props:{
      /**
			 * Opciones a mostrar en el select
			 * @type {array}
			 */
      options:{
        type: Array,
        required: true,
        default: function(){
          return []
        }
      },
      /**
			 * Texto a mostrar en la etiqueta de la opcion vacia
			 * @type {string}
			 */
      emptyText:{
        type: String,
        required: false,
        default: 'Seleccionar'
      },
      /**
			 * Texto a mostrar en la etiqueta de la opcion 'Otro'
			 * @type {string}
			 */
      otherText:{
        type: String,
        required: false,
        default: 'Otro'
      },
    },
    methods:{
      cancelar(){
        this.selected = ''
        this.show = !this.show
      },
      confirmar(){
        this.theOptions.pop()
        this.theOptions.push(this.newOption)
        this.theOptions.push(this.otherText)
        this.selected = this.newOption
        this.newOption = ''
        this.show = !this.show
      }

    },
    data(){
      return{
        selected: '',
        newOption: '',
        theOptions: this.options,
        show: false,
      }
    },
    mounted(){
      this.theOptions.push(this.otherText)
    },
    watch:{
      selected: function(){
        if(this.selected == this.otherText)
          this.show = !this.show
      }
    },
  }
</script>
