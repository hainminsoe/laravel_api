<template>
   <div>
      <h2>This is Article</h2>
      <nav aria-label="Page navigation example">
         <ul class="pagination">
            <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
               <a class="page-link" href="#" @click="getArticles(pagination.prev_page_url)">Previous</a>
            </li>
            <li class="page-item">
               <a class="page-link">{{pagination.current_page}} of {{pagination.last_page}}</a>
            </li>
            <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
               <a class="page-link" href="#" @click="getArticles(pagination.next_page_url)">Next</a>
            </li>
         </ul>
      </nav>
      <hr>
      <form class="mb-5" @submit.prevent="addArticles">
         <div class="form-group">
            <input type="text" class="form-control" placeholder="Title" v-model="article.title">
         </div>
         <div class="form-group">
            <input type="textarea" class="form-control" placeholder="Description" v-model="article.body">
         </div>
         <button class="submit btn btn-success btn-block">Create</button>
      </form>
      <div class="row">
         <div class="col-sm-12 mb-3" v-for="article in articles" v-bind:key="article.id">
            <div class="card">
               <div class="card-body">
               <h3 class="card-title">{{article.title}}</h3>
               <p class="card-text">{{article.body}}</p>
              
               <a href="#" class="btn btn-primary">See More</a>
               <a href="#" class="btn btn-danger" @click="deleteArticles(article.id)">Delete</a>
               <a href="#" class="btn btn-danger" @click="editArticles(article)">Edit</a>
               </div>
            </div>
         </div>
      </div>
   </div>
</template>

<script>
   export default {
      data(){
         return{
            articles:[],
            article:{
               id: '',
               title:'',
               body:''
            },
            articles_id:'',
            pagination:{},
            edit:false
         }
      },
      created(){
         this.getArticles();
      },
      methods:{
         getArticles(page_url){
            let vm = this;
            page_url = page_url || '/api/articles'
            axios.get(page_url).then(response => response.data).then(response=>{
               this.articles = response.data;
               vm.makePagination(response.meta,response.links);
            })
         },
         makePagination(meta, links){
            let pagination = {
              current_page: meta.current_page,
              last_page: meta.last_page,
              next_page_url: links.next,
              prev_page_url: links.prev

            };
         },            this.pagination = pagination;

         deleteArticles(id){
            if(confirm('Are you sure?')){
               fetch(`api/articles/${id}` ,{
                  method: 'delete'
               })
               .then(data =>{
                  // alert('Successfully Removed');
                  this.getArticles();
               })
            }
         },
         addArticles(){
            if(this.edit === false){
               // add article
               fetch('/api/articles',{
                  method: 'post',
                  body: JSON.stringify(this.article),
                  headers:{
                     'content-type':'application/json'
                  },
                  
               }).then(response => response.data).then(response=>{
                  this.article.title = '';
                  this.article.body = '';
                  this.getArticles();
                  console.log(this)
               })
            }else{
               //update article
               fetch('/api/articles',{
                  method: 'put',
                  body: JSON.stringify(this.article),
                  headers:{
                     'content-type':'application/json'
                  },
                  
               }).then(response => response.data).then(response=>{
                  this.article.title = '';
                  this.article.body = '';
                  this.getArticles();
                  console.log(this.article);
               })
            }
            
         },
         editArticles(article){
            this.edit = true;
            this.article.id = article.id;
            this.article.articles_id = article.id;
            this.article.title = article.title;
            this.article.body = article.body;
         }
         
      }
   }   
</script>