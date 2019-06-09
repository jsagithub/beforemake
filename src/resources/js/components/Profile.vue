<template>
    <div class="container-fluid container-margin--top">
        <div class="row">
            <div class="col-3">
                <ranking></ranking>
            </div>
            <div class="col">
                <idea :storie_to_edit="storie_to_edit" v-if="!show_idea"></idea>
                <stories v-if="show_idea" @clicked="fulFielldForm"></stories>
            </div>
        </div>
        <div class="flex-row-reverse">
                <div class="float-right">
                    <button class="btn btn-primary"><i class="fas fa-print"></i> Print</button>
                    <button class="btn btn-primary"><i class="far fa-thumbs-up"></i></button>
                    <button class="btn btn-primary"><i class="fas fa-share-alt"></i>Share</button>
                    <button class="btn btn-primary"><i class="fab fa-kickstarter-k"></i>ickstarter</button>
                </div>
            </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            show_idea:false,
            storie_to_edit: []
        }
    },
    created(){
        if(!isNaN(window.location.search.split("?")[1])){
           this.show_idea = true;
        }        
       
    },
    methods:{
        fulFielldForm(value){
            this.storie_to_edit = value;
            this.show_idea = false;
        }
    }
}
</script>
