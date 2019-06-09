<template>
    <div>
        <h4>Projects</h4>
        <ul class="list-group">
            <li v-for="project in projects" class="list-group-item">
                <a :href="'/profile?'+project.id">
                {{project.title}}
                </a>
            </li>          
        </ul>    
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
