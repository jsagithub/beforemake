<template>
    <div>
        <h4>Projects</h4>
        <div class="ranking-block">
            <div class="ranking-row" v-for="project in projects">                
                <div class="ranking-content">
                    <div class="row">
                        <div class="col-8" style="font-size:12px;">
                            <div>
                                <img :src="project.user.img" class="img-fluid rounded" style="width:25px;"> 
                                {{project.user.name}}
                                <a>
                                    {{project.comment}}
                                </a>
                            </div>
                            <a :href="'/profile?'+project.id">
                                {{project.title}}
                            </a>
                        </div>
                        <div class="col-2 ranking-content_arrows">
                            <button>
                                <i class="fas fa-chevron-up"></i>
                            </button>
                            <div>10</div>
                            <button>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            projects: [],
            id_user: 1
        }
    },
    created(){
        axios.get('/api/projects_by_user/'+this.id_user)
        .then(response => {   
            this.projects= response.data;  
        }).catch(error => {
            console.log(error.response);               
        });
    }
}
</script>
