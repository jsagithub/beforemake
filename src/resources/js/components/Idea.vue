<template>
    <div class="container">
        <h5>New Project</h5>
        <form>
            <div class="form-row">
                <div class="col">
                    <input v-model="project_title" type="text" class="form-control" placeholder="Project name">
                </div>
                <div class="col">
                    <input v-model="project_description" type="text" class="form-control" placeholder="Project Description">
                </div>
            </div>
            <hr>
            <div class="form-row">
                <input v-model="youtube_url" type="text" class="form-control" placeholder="Youtube Link">
                <input v-model="instagram_url" type="text" class="form-control" placeholder="Instagram Link">
                <input v-model="twitter_url" type="text" class="form-control" placeholder="Twitter Link">
                <input v-model="facebook_url" type="text" class="form-control" placeholder="Facebook Link">           
            </div>
            <hr>
            <h6>Stories</h6>
            <button type="button" @click="addStorieForm" class="btn btn-success">+</button>
            <div class="form-row" v-for="(storie, index) in stories">                
                <div class="col">
                    <textarea v-model="storie.description" class="form-control" id="storie_description" placeholder="Storie Description" rows="3"></textarea>
                </div>
                <div class="col">
                    <div class="input-group mb-3">
                        <input v-model="form.image_url[index]" type="text" class="form-control" placeholder="Image Link" aria-label="Image Link">
                        <div class="input-group-append">
                            <button @click="addImage(index,form.image_url[index])" class="btn btn-outline-secondary" type="button" id="button-addon2">Add</button>
                        </div>
                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img class="d-block w-100" src="https://www.mpaa.org/wp-content/uploads/2018/03/466036929-1.jpg" alt="First slide">
                                </div>  
                                <div class="carousel-item" v-for="image in storie.images">
                                    <img class="d-block w-100" :src="image" alt="First slide">
                                </div>                               
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="input-group mb-3">
                        <input type="text" v-model="form.video_url[index]" class="form-control" placeholder="Video Link" aria-label="Video Link">
                        <div class="input-group-append">
                            <button @click="addVideo(index,form.video_url[index])" class="btn btn-outline-secondary" type="button" id="button-addon2">Add</button>
                        </div>
                       <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <iframe width="100%" src="https://www.youtube.com/embed/DJ6PD_jBtU0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                                <div class="carousel-item"  v-for="video in storie.videos">
                                    <iframe width="100%" :src="video" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>                                
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-danger"  @click="removeStorieForm(index)">-</button>
            </div>
            <button type="button" class="btn btn-success" @click="saveProject">Add/Edit</button>
            <button type="button" class="btn btn-danger">Delete</button>
        </form>
    </div>
</template>
<script>
export default {
    data (){
        return {
            project_title: '',
            project_description: '',
            youtube_url: '',
            instagram_url: '',
            twitter_url: '',
            facebook_url: '',
            stories: [{images:[], videos:[]}],
            form: {
                image_url: [],
                video_url: []
            }
            
        }
    },
    methods:{
        addStorieForm() {
            this.stories.push({images:[], videos:[]});
        },
        removeStorieForm(position){
            this.stories.splice(position, 1);
        },
        addImage(index,url_img){
            this.stories[index].images.push(url_img);
        },
        addVideo(index,url_video){
            this.stories[index].videos.push(url_video);
        },
        saveProject(){
            let data = {
                title: this.project_title,
                description:  this.project_description,
                nlikes: 0,
                id_project_status: 1
            }
            axios.post('/api/projects', data)
            .then(response => {   
               if(response.status===201){
                  this.saveStories(response.data.data.id);
                  this.saveSocialMedia(response.data.data.id);
                  this.addProjectRanking(response.data.data.id, 1);
               }     
            }).catch(error => {
                console.log(error.response);               
            });
        },
        saveStories(id_project){
            this.stories.forEach(storie => {
                let data = {
                    id_project: id_project,
                    description: storie.description,
                    nlikes:0
                };
                axios.post('/api/stories', data)
                .then(response => {                   
                if(response.status===201){ 
                    this.saveImages(response.data.data.id,storie.images);
                    this.saveVideos(response.data.data.id,storie.videos);                   
                }     
                }).catch(error => {
                    console.log(error.response);               
                });
            });
        },
        saveImages(id_storie, images){
            images.forEach(image => {
                let data = {
                    id_stories: id_storie,
                    url: image
                }
                axios.post('/api/images', data)
                .then(response => {                   
                  
                }).catch(error => {
                    console.log(error.response);               
                });
            });
        },
        saveVideos(id_storie, videos){
            videos.forEach(video => {
                let data = {
                    id_stories: id_storie,
                    url: video
                }
                console.log(data);
                axios.post('/api/videos', data)
                .then(response => {     

                }).catch(error => {
                    console.log(error.response);               
                });
            });
        },
        saveSocialMedia(id_project){
           if(this.youtube_url!=''){
               let data = {
                   id_project: id_project,
                   name: "Youtube",
                   icon: "youtube_icon",
                   url: this.youtube_url
               }
               this.sentDataSocialMedia(data);
           }
           if(this.instagram_url != ''){
               let data = {
                   id_project: id_project,
                   name: "Instagram",
                   icon: "instagram_icon",
                   url: this.instagram_url
               }
               this.sentDataSocialMedia(data);
           }
           if (this.twitter_url != ''){
               let data = {
                   id_project: id_project,
                   name: "Twitter",
                   icon: "twitter_icon",
                   url: this.twitter_url
               }
               this.sentDataSocialMedia(data);
           }
           if(this.facebook_url){
               let data = {
                   id_project: id_project,
                   name: "Facebook",
                   icon: "facebook_icon",
                   url: this.facebook_url
               }
               this.sentDataSocialMedia(data);
           }
        },
        sentDataSocialMedia(data){
            axios.post('/api/social', data)
            .then(response => {                   
                console.log(response);
            }).catch(error => {
                console.log(error.response);               
            });
        },
        addProjectRanking(id_project,id_project_status){
            let data = {
                id_project: id_project,
                position:0,
                id_project_status:id_project_status
            }
            axios.post('/api/rankings', data)
            .then(response => {                   
                console.log(response);
            }).catch(error => {
                console.log(error.response);               
            });
        }
    }
}
</script>
