<template>
    <div class="container">       
        <!-- Modal -->
        <div class="modal fade" id="ideaModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Storie</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" @click="removeStorieForm(index_storie)">Delete</button>
                </div>
                </div>
            </div>
        </div>
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
            <div style="margin-top: 5px;" class="form-row" v-for="(storie, index) in stories">                
                <div class="col">
                    <textarea style="height: 220px;" v-model="storie.description" class="form-control" id="storie_description" placeholder="Storie Description" rows="3"></textarea>
                </div>
                <div class="col">
                    <div class="input-group mb-3">
                        <input v-model="form.image_url[index]" type="text" class="form-control" placeholder="Image Link" aria-label="Image Link">
                        <div class="input-group-append">
                            <button @click="addImage(index,form.image_url[index])" class="btn btn-outline-secondary" type="button" id="button-addon2">Add</button>
                        </div>
                        <div  style="margin-top: 10px;" :id="'carouselExampleControls'+index" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">                                
                                <div class='carousel-item' :class="{'active': i_img==0}" v-for="(image, i_img) in storie.images">
                                    <img style="height: 173px;" class="d-block w-100" :src="image.url">
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
                        <input type="text" v-model="form.video_url[index]" class="form-control" placeholder="Video Link" aria-label="Video Link">
                        <div class="input-group-append">
                            <button @click="addVideo(index,form.video_url[index])" class="btn btn-outline-secondary" type="button" id="button-addon2">Add</button>
                        </div>
                       <div style="margin-top: 10px;" :id="'carouselVideoControls'+index" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">                               
                                <div class="carousel-item" :class="{'active': i_vid==0}" v-for="(video, i_vid) in storie.videos">
                                    <iframe style="height: 173px;" width="100%" :src="video.url" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
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
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ideaModal" @click="changeIndexStorie(index)">-</button>
            </div>
            <button v-if="is_new_project" type="button" class="btn btn-success" @click="saveProject">Add</button>
            <button v-if="!is_new_project" type="button" class="btn btn-success" @click="editProject">Edit</button>            
        </form>
    </div>
</template>
<script>
export default {
    props:{
        storie_to_edit: {type: Array}
    },
    data (){
        return {
            is_new_project: true,
            project_title: '',
            project_description: '',
            youtube_url: '',
            youtube_id: 0,
            instagram_url: '',
            instagram_id: 0,
            twitter_url: '',
            twitter_id: 0,
            facebook_url: '',
            facebook_id: 0,
            stories: [{images:[], videos:[]}],
            form: {
                image_url: [],
                video_url: []
            },
            index_storie: 0
            
        }
    },
    created(){
        if(this.storie_to_edit.length>0){
            this.is_new_project = false;
            this.stories=this.storie_to_edit;
            this.getProject(this.storie_to_edit[0].id_project);
            this.getSocialMedia(this.storie_to_edit[0].id_project);
        }
    },
    methods:{
        addStorieForm() {
            this.stories.push({images:[], videos:[]});
        },
        removeStorieForm(position){
            if(!this.is_new_project){
                this.deleteStorie(this.stories[position].id)
            }
            this.stories.splice(position, 1);            
        },
        addImage(index,url_img){
            this.stories[index].images.push({'url':url_img});
        },
        addVideo(index,url_video){
            let code_split = url_video.split('v=');
            url_video = "https://www.youtube.com/embed/"+code_split[1];
            this.stories[index].videos.push({'url':url_video});
        },
        saveProject(){
            let data = {
                title: this.project_title,
                description:  this.project_description,
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
                if(!storie.id){
                    let data = {
                        id_project: id_project,
                        description: storie.description
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
                }
            });
        },
        saveImages(id_storie, images){
            images.forEach(image => {
                if(!image.id){
                    let data = {
                        id_stories: id_storie,
                        url: image.url
                    }
                    axios.post('/api/images', data)
                    .then(response => {                   
                    
                    }).catch(error => {
                        console.log(error.response);               
                    });
                }
            });
        },
        saveVideos(id_storie, videos){
            videos.forEach(video => {
                if(!video.id){
                    let data = {
                        id_stories: id_storie,
                        url: video.url
                    }
                    axios.post('/api/videos', data)
                    .then(response => {     

                    }).catch(error => {
                        console.log(error.response);               
                    });
                }
            });
        },
        saveSocialMedia(id_project){
           if(this.youtube_url!=''){
               let data = {
                   id_project: id_project,
                   name: "Youtube",
                   icon: "fa-youtube",
                   url: this.youtube_url
               }
               this.sentDataSocialMedia(data);
           }
           if(this.instagram_url != ''){
               let data = {
                   id_project: id_project,
                   name: "Instagram",
                   icon: "fa-instagram",
                   url: this.instagram_url
               }
               this.sentDataSocialMedia(data);
           }
           if (this.twitter_url != ''){
               let data = {
                   id_project: id_project,
                   name: "Twitter",
                   icon: "fa-twitter",
                   url: this.twitter_url
               }
               this.sentDataSocialMedia(data);
           }
           if(this.facebook_url){
               let data = {
                   id_project: id_project,
                   name: "Facebook",
                   icon: "fa-facebook",
                   url: this.facebook_url
               }
               this.sentDataSocialMedia(data);
           }
        },
        sentDataSocialMedia(data){
            axios.post('/api/social', data)
            .then(response => {        
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
            }).catch(error => {
                console.log(error.response);               
            });
        },
        getProject(id_project){
            axios.get('/api/projects/'+id_project)
            .then(response => { 
                this.project_title = response.data.data.title;
                this.project_description = response.data.data.description;
            }).catch(error => {
                console.log(error.response);               
            });
        },
        getSocialMedia(id_project){
            axios.get('/api/social_by_project/'+id_project)
            .then(response => {
                let social = response.data;
                social.forEach(social => {
                    if(social.name==="Youtube"){
                        this.youtube_url = social.url;
                        this.youtube_id = social.id;
                    }
                    if(social.name==="Instagram"){
                        this.instagram_url = social.url;
                        this.instagram_id = social.id;
                    }
                    if(social.name==="Twitter"){
                        this.twitter_url = social.url;
                        this.twitter_id = social.id;
                    }
                    if(social.name==="Facebook"){
                        this.facebook_url = social.url;
                        this.facebook_id = social.id;
                    }
                });
            }).catch(error => {
                console.log(error.response);               
            });
        },
        editProject(){
            this.editProjectData();
            this.editSocialMedia();
            this.editStorie();
        },
        editProjectData(){
            let data={
                project_id:this.storie_to_edit[0].id_project,        
                title: this.project_title,
                description: this.project_description,
                id_project_status: 1
            }
            axios.put('/api/projects', data)
            .then(response => {      
            }).catch(error => {
                console.log(error.response);               
            });
        },
        editSocialMedia(){
            if(this.youtube_id>0){
                let data_y = {
                    social_id: this.youtube_id,
                    id_project: this.storie_to_edit[0].id_project,
                    name: "Youtube",
                    icon: "youtube_icon",
                    url: this.youtube_url,
                }            
                this.editSocialMediaData(data_y);
            }
            else if(this.youtube_url.length>0){
                this.saveSocialMedia(this.storie_to_edit[0].id_project);
            }
            if(this.instagram_id>0){
                let data_i = {
                    social_id: this.instagram_id,
                    id_project: this.storie_to_edit[0].id_project,
                    name: "Instagram",
                    icon: "instagram_icon",
                    url: this.instagram_url,
                }
                this.editSocialMediaData(data_i);
            }
            else if(this.instagram_url.length>0){
                this.saveSocialMedia(this.storie_to_edit[0].id_project);
            }
            if(this.twitter_id>0){
                let data_t = {
                    social_id: this.twitter_id,
                    id_project: this.storie_to_edit[0].id_project,
                    name: "Twitter",
                    icon: "twitter_icon",
                    url: this.twitter_url,
                }
                this.editSocialMediaData(data_t);
            }
            else if(this.twitter_url.length>0){
                this.saveSocialMedia(this.storie_to_edit[0].id_project);
            }
            if(this.facebook_id>0){
                let data_f = {
                    social_id: this.facebook_id,
                    id_project: this.storie_to_edit[0].id_project,
                    name: "Facebook",
                    icon: "facebook_icon",
                    url: this.facebook_url,
                }
                this.editSocialMediaData(data_f);
            }
            else if(this.facebook_url.length>0){
                this.saveSocialMedia(this.storie_to_edit[0].id_project);
            }           
        }, 
        editSocialMediaData(data){
            axios.put('/api/social', data)
            .then(response => {       
            }).catch(error => {
                console.log(error.response);               
            });
        },
        editStorie(){
            this.storie_to_edit.forEach(storie => {
                if(storie.id){
                    let data_storie={
                        storie_id: storie.id,
                        id_project: storie.id_project,
                        description: storie.description,
                    }
                    axios.put('/api/stories', data_storie)
                    .then(response => { 
                        if(storie.images.length>0){
                            this.saveImages(storie.id,storie.images);
                        }
                        if(storie.videos.length>0){
                            this.saveVideos(storie.id,storie.videos);
                        } 
                    }).catch(error => {
                        console.log(error.response);               
                    });
                }                
            });
            //save new stories if they exists
            this.saveStories(this.storie_to_edit[0].id_project);
        },
        deleteStorie(id_storie){
            axios.delete('/api/stories/'+id_storie)
            .then(response => { 
                console.log(response);
            }).catch(error => {
                console.log(error.response);               
            });
        },
        changeIndexStorie(index){
            this.index_storie = index;
        }

    }
}
</script>
