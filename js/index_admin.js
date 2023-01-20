Vue.createApp({
    data() {
      return {
            q:'2254',
            url_base:'',
            url_base_app:'',
            url_base_now:'',
            datas: '',
            project:{
                name:'',
                year:'',
                date_train:'',
                detail:'',
                period : 1,
                img : '',
                template:[],
                text:[],
                act:'insert',
            },
            projects: [],
            templates: [],
            c_users: [],
            template:{project_id :'',size : 'A4', orientation : 'L'},
            font_name:['thsarabun','prompt'],
            url_preview:'',
            isLoading : false,
        }
    },
    mounted(){
        window.setTimeout(this.fadeout(), 200);
        this.get_projects()
    },
    
    methods: {
        fadeout() {
            isLoading = false
            // document.querySelector('.preloader').style.opacity = '0';
            // document.querySelector('.preloader').style.display = 'none';
        },
        bnt_loading(){
            this.alert("success","message",timer=0)
            this.isLoading = !this.isLoading
        },
        cls_modal_project(){
            this.project = {name:'',year:'' ,date_train:'', detail:'', period:'', img:'',
            template:'', name_font:'prompt', name_font_size:36, name_y:69, act:'insert'}
            this.url_preview = ''
        },
        get_project(id){
            axios.post('./api/cert/get_project.php',{id:id})    
                .then(response => {
                    this.project = response.data.rep
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        get_projects(){
            this.isLoading = true;
            axios.get('./api/cert/get_projects.php')
            .then(response => {
                if (response.data.status) {
                    this.datas = response.data
                    this.projects = response.data.projects
                } 
            })
            .catch(function (error) {
                console.log(error);
            })
            .finally(() => {
                this.isLoading = false;
            })
        
        }, 
        cert_users(id){
            this.isLoading = true;
            axios.post('./api/cert/get_cert_users.php',{id:id})
            .then(response => {
                if (response.data.status) {
                    this.c_users = response.data.c_users
                    this.$refs.modal_cert_user.click()
                } else{
                    this.alert("error",response.data.message,5000)
                }
            })
            .catch(function (error) {
                console.log(error);
            })
            .finally(() => {
                this.isLoading = false;
            })

        },
        modal_cert_usert_close(){

        },
        print(id){
            this.isLoading = true
            axios.post('./api/cert/print.php',{id:id})    
            .then(response => {
                if (response.data.status) {
                    axios.post('/mpdf/api/cert/index.php',{
                        data    : response.data.resp
                    }) 
                    .then(response => {
                        url = response.data.url
                        // console.log(url)
                        window.open(url,'_blank')
                    })
                }else{
                  this.alert('warning',response.data.message,0)
                } 
            })
            .catch(function (error) {
                console.log(error);
            })
            .finally(() => {
                this.isLoading = false;
            })
  
        }, 
        project_add(){
            this.project.act ='insert'
            this.$refs.modal_project.click()
        },
        project_update(id){
            axios.post('./api/cert/get_project.php',{id:id})    
                .then(response => {
                    this.project = response.data.rep
                    this.project.act ='update'
                    this.$refs.modal_project.click()
                })
                .catch(function (error) {
                    console.log(error);
                });
            this.project.act ='update'
            this.$refs.modal_project.click()
        },
        project_save(){
            if(this.project.name != ''){
                this.isLoading = true
                axios.post('./api/cert/project_act.php',{project:this.project})    
                    .then(response => {
                        if(response.data.status){
                            this.alert('success',response.data.message,timer=1000)
                            this.get_projects()
                        }else{
                            this.alert('warning',response.data.message,timer=0)
                        }
                        this.modal_project_close()
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                    .finally(() => {
                        this.isLoading = false;
                    })
                
            }
        },
        project_del(id){
            Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.post('./api/cert/project_act.php',{project:{id:id, act:'del'}}) 
                        .then(response => {
                            this.alert('success',response.data.message,timer=1000)
                            this.get_projects()
                          })
                          .catch(function (error) {
                              console.log(error);
                          });
                      } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info')
                      }
                })
        },
        modal_project_close(){
           this.cls_modal_project()
           this.$refs.btn_project_close.click()
        },
        
        

        add_users(template){
            Swal.fire({
                title: 'Are you sure?',
                text: "เพิ่มรายชื่อ!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('./api/cert/add_users.php',{template:template})    
                        .then(response => {
                            if(response.data.status){
                                this.alert('success',message,timer=0)
                                this.get_project()
                            }
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                    this.get_projects()
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                  }
              })
        },
        del_user(pju){
            Swal.fire({
                title: 'Are you sure?',
                text: "ต้องการลบ "+pju.name,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('./api/cert/del_user.php',{id:pju.id})    
                        .then(response => {
                            this.get_projects()
                            this.alert('success',response.data.message,timer=1000)
                        })
                        .catch(function (error) {
                            console.log(error);
                        });                    
                    this.get_projects()
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            })
              
        },
        bnt_img_show(id){
            axios.post('./api/cert/get_project.php',{id:id})    
            .then(response => {
                this.project = response.data.rep
                this.project.act ='update_img'
                this.$refs.img_m_show.click()
            })
            .catch(function (error) {
                console.log(error);
            });
            

        },
        bnt_img_close(){          
            this.cls_modal_project()
        },
        onUpload_img(){
            // console.log(this.$refs.myFiles.files[0].name);
            var image = this.$refs.myImg.files
            if (image.length > 0) {
              if(image[0].type == 'image/jpeg' || image[0].type =='image/png') {
                var formData = new FormData();
                // var imagefile = document.querySelector('#file');
                formData.append("sendimage", image[0]);
                formData.append("id", this.project.id);
                axios.post('./api/cert/project_upload_img.php', 
                  formData, 
                  {headers:{'Content-Type': 'multipart/form-data'}
                })
                  .then(response => {
                      if (response.data.status) {
                        
                        this.project.img = response.data.img;
                        this.get_projects()
                        // this.$refs.modal_img_close.click()
      
                      }else {
                          swal.fire({
                              icon: 'error',
                              title: response.data.message,
                              showConfirmButton: true,
                              timer: 1500
                          });
                      }
                  })
              } else{
                  swal.fire({
                      icon: 'error',
                      title: "ไฟล์ที่อัพโหลดต้องเป็นไฟล์ jpeg หรือ png เท่านั้น",
                      showConfirmButton: true,
                      timer: 1500
                  });
                }
            }      
        },
        btn_template_show(id){
            axios.post('./api/cert/get_project.php',{id:id})    
            .then(response => {
                this.project = response.data.rep
                this.project.act ='update_template'
            })
            .catch(function (error) {
                console.log(error);
            });

        },
        onUpload_template(){
            // console.log(this.$refs.myFiles.files[0].name);
            var tm = this.$refs.myTemplate.files
            if (tm.length > 0) {
              if(tm[0].type == 'application/pdf') {
                var formData = new FormData();
                formData.append("sendpdf", tm[0]);
                formData.append("id", this.template.project_id);
                axios.post('./api/cert/project_upload_template.php', 
                  formData, 
                  {headers:{'Content-Type': 'multipart/form-data'}
                })
                  .then(response => {
                      if (response.data.status) {
                        
                        this.project.template = response.data.template;
                        this.get_projects()
                        this.$refs.modal_template_close.click()
      
                      }else {
                          swal.fire({
                              icon: 'error',
                              title: response.data.message,
                              showConfirmButton: true,
                              timer: 1500
                          });
                      }
                  })
              } else{
                  swal.fire({
                      icon: 'error',
                      title: "ไฟล์ที่อัพโหลดต้องเป็นไฟล์ jpeg หรือ png เท่านั้น",
                      showConfirmButton: true,
                      timer: 1500
                  });
                }
            }      
        },
        template_preview(){
            this.isLoading = true
            
            axios.post('/mpdf/api/cert/preview.php',{
                data    : this.project
            }) 
            .then(response => {
                this.url_preview = response.data.url
                // console.log(url)
                // window.open(url,'_blank')
            })           
            .catch(function (error) {
                console.log(error);
            })
            .finally(() => {
                this.isLoading = false;
            })
        },
        
        btn_template_del(template){
            Swal.fire({
                title: 'Are you sure?',
                text: "ต้องการ Template " + template.id ,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('./api/cert/template_del.php',{template:template})    
                        .then(response => {
                            this.alert('success',response.message,timer=1000)
                            this.get_projects()
                        })
                        .catch(function (error) {
                            console.log(error);
                        });                    
                    // this.get_projects()
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            })
        },
        template_add(id){
            this.template.project_id = id
            this.template.size = 'A4'
            this.template.orientation = 'L'
            this.$refs.btn_modal_template_show.click()
        },
        template_update(id){
            axios.post('./api/cert/get_template.php',{id:id})    
                .then(response => {
                    this.template = response.data.template                    
                    this.$refs.btn_modal_template_show.click()
                })
                .catch(function (error) {
                    console.log(error);
                });
            // console.log('dd')        
        },
        name_y_update(){
            this.project.act = 'name_y_update'
            axios.post('./api/cert/project_act.php',{project:this.project})    
            .then(response => {
                if(response.data.status){
                    // this.alert('success',response.data.message,timer=1000)
                    this.template_preview()
                }else{
                    this.alert('warning',response.data.message,timer=0)
                }
            })
            .catch(function (error) {
                console.log(error);
            })
            .finally(() => {
                this.isLoading = false;
            })
        },
        name_font_update(){
            this.project.act = 'name_font_update'
            axios.post('./api/cert/project_act.php',{project:this.project})    
            .then(response => {
                if(response.data.status){
                    // this.alert('success',response.data.message,timer=1000)
                    this.template_preview()
                }else{
                    this.alert('warning',response.data.message,timer=0)
                }
            })
            .catch(function (error) {
                console.log(error);
            })
            .finally(() => {
                this.isLoading = false;
            })
        },
        name_font_size_update(){
            this.project.act = 'name_font_size_update'
            axios.post('./api/cert/project_act.php',{project:this.project})    
            .then(response => {
                if(response.data.status){
                    // this.alert('success',response.data.message,timer=1000)
                    this.template_preview()
                }else{
                    this.alert('warning',response.data.message,timer=0)
                }
            })
            .catch(function (error) {
                console.log(error);
            })
            .finally(() => {
                this.isLoading = false;
            })
        },
       

     
      alert(icon,message,timer=0){
        swal.fire({
          icon: icon,
          title: message,
          showConfirmButton: true,
          timer: timer,
        });
      },
    },
  
  }).mount('#index_admin')

  