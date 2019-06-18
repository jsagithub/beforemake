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
                            <button @click="upRanking(project.ranking[0].id, project.id,project.ranking[0].position)">
                                <i class="fas fa-chevron-up"></i>
                            </button>
                            <div>{{project.ranking[0].position}}</div>
                            <button @click="downRanking(project.ranking[0].id, project.id,project.ranking[0].position)">
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
            id_user: 0,
            is_profile: false
        }
    },
    created(){
        this.getUserInfo();        
    },
    methods:{
        getUserInfo(){
            axios.get('/api/user')
            .then(res => {    
                if(res){ 
                    this.id_user = res.data.id;
                    if(!isNaN(window.location.search.split("?")[1])){
                        this.getProjects();
                        this.is_profile = true;
                    }
                    else{
                        this.getProjectsByStatus();
                    }
                }
                else{
                    this.getProjectsByStatus();
                }
            })
            .catch(err => {
                this.getProjectsByStatus();
            });
        },    
        getProjects(){            
            this.projects = [];
            axios.get('/api/projects_by_user/'+this.id_user)
            .then(response => { 
                response.data.forEach(project => {
                    axios.get('/api/rankings_by_project/'+project.id)
                    .then(response => {   
                        let ranking_data = response.data;                    
                        project.ranking = ranking_data;
                        this.projects.push(project);
                    }).catch(error => {
                        console.log(error.response);               
                    });
                });            
            }).catch(error => {
                console.log(error.response);               
            });          
        },
        getProjectsByStatus(){
            this.projects = [];
            axios.get('/api/rankings_by_status/1')
            .then(response => {
                console.log(response.data); 
                response.data.forEach(ranking => {
                    let project = ranking.project;  
                    project.user = ranking.user;                 
                    project.ranking = [{'id':ranking.id, 'position':ranking.position}];
                    this.projects.push(project);
                });  
                
            }).catch(error => {
                console.log(error.response);               
            });
        },
        upRanking(id_ranking, id_project, current_position){
            let data = {
                ranking_id: id_ranking,
                id_project: id_project,
                position: current_position+1,
                id_project_status: 1
            }
            axios.put('/api/rankings', data)
            .then(response => {  
               if(this.is_profile){               
                this.getProjects();
               }
               else{
                   this.getProjectsByStatus();
               }
            }).catch(error => {
                console.log(error.response);               
            });
        },
        downRanking(id_ranking, id_project, current_position){
            let data = {
                ranking_id: id_ranking,
                id_project: id_project,
                position: current_position-1,
                id_project_status: 1
            }
            axios.put('/api/rankings', data)
            .then(response => {                  
               if(this.is_profile){               
                this.getProjects();
               }
               else{
                   this.getProjectsByStatus();
               }
            }).catch(error => {
                console.log(error.response);               
            });
        }
    }
}
</script>
