<template>
<div class="container">
        <h5>{{project_name}}</h5>  
        <div v-for="(storie, index) in stories">         
            <div class="row" style="background-color: #f5f5f5; padding: 10px;">                
                <div class="col">
                    {{storie.description}}
                </div>
                <div class="col">
                    <div class="input-group mb-3">                       
                        <div :id="'carouselExampleControls'+index" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">                               
                                <div class="carousel-item" :class="{'active': i_img==0}" v-for="(image, i_img) in storie.images">
                                    <img class="d-block w-100" :src="image.url">
                                </div>                               
                            </div>
                            <a class="carousel-control-prev" :href="'#carouselExampleControls'+index" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" :href="'#carouselExampleControls'+index" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="input-group mb-3">                       
                        <div :id="'carouselVideoControls'+index" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">                                
                                <div class="carousel-item"  :class="{'active': i_vid==0}" v-for="(video, i_vid) in storie.videos">
                                    <iframe width="100%" :src="video.url" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>                                
                            </div>
                            <a class="carousel-control-prev" :href="'#carouselVideoControls'+index" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" :href="'#carouselVideoControls'+index" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>                    
            </div>
            <div class="row profile--gray-content profile--scroll-content">
                <div class="col" style="padding: 5px; border: 1px solid rgb(223, 222, 222);">
                    <div style="max-height: 300px; overflow: scroll;">
                        <div v-for="comment in storie.comments" class="profile--info">
                            <h4 class="card-title">
                                <img :src="comment.user.img" class="img-fluid rounded" style="width:50px;"> 
                                {{comment.user.name}}
                                <a style="font-size:15px;">
                                    {{comment.comment}}
                                </a>
                            </h4>
                        </div>  
                    </div>                  
                    <div class="input-group mb-3">
                        <input v-model="storie.new_comment" type="text" class="form-control" placeholder="Write a message" aria-label="Write a message" aria-describedby="button-addon2">
                        <div class="input-group-append">
                            <button @click="addComment(storie.id,storie.new_comment)" class="btn btn-outline-secondary" type="button">Comment</button>
                        </div>
                    </div>
                </div>
            </div>     
        </div>      
        <button @click="editProject" type="button" class="btn btn-success">Edit</button>
        <button type="button" @click="deleteProject" class="btn btn-danger">Delete</button>
   </div>
</template>
<script>
export default {
    data(){
        return{
            project_name: '',
            id_project: 0,
            stories: []
        }
    },
    created(){
        if(!isNaN(window.location.search.split("?")[1])){
            this.id_project=window.location.search.split("?")[1];
            this.getProject();
            this.getStories();
        }        
       
    },
    methods:{
        getProject(){
            axios.get('/api/projects/'+this.id_project)
            .then(response => { 
                this.project_name= response.data.data.title;  
            }).catch(error => {
                console.log(error.response);               
            });
        },
        getStories(){
            axios.get('/api/stories_by_project/'+this.id_project)
            .then(response => {   
                this.stories= response.data;  
            }).catch(error => {
                console.log(error.response);               
            });
        },
        addComment(id_storie, comment){
            console.log(id_storie, comment);
            let data = {
                id_stories: id_storie,
                comment: comment
            }
            axios.post('/api/comment', data)
            .then(response => {   
               this.getStories();
            }).catch(error => {
                console.log(error.response);               
            });
        },
        deleteProject(){
            axios.delete('/api/projects/'+this.id_project)
            .then(response => {   
                this.getStories();
            }).catch(error => {
                console.log(error.response);               
            });
        },
        editProject(){
            this.$emit('clicked', this.stories);
        }
    }
}
</script>
