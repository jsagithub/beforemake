<template>
    <div class="container-fluid container-margin--top">
        <div class="row">
            <div class="col-3">
                <h4>Projects</h4>
                <ul class="list-group">
                    <li class="list-group-item active" @click="show_idea=!show_idea">Cras justo odio</li>
                    <li class="list-group-item">Dapibus ac facilisis in</li>
                    <li class="list-group-item">Morbi leo risus</li>
                    <li class="list-group-item">Porta ac consectetur ac</li>
                    <li class="list-group-item">Vestibulum at eros</li>
                </ul>               
            </div>
            <div class="col">
                <idea v-if="!show_idea"></idea>
                <stories v-if="show_idea"></stories>
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
            show_idea:false
        }
    }
}
</script>
