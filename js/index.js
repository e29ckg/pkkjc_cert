Vue.createApp({
    data() {
      return {
            q:'2254',
            url_base:'',
            url_base_app:'',
            url_base_now:'',
            datas: '',
            projects: [
                {
                id: 2023001,
                name:'โครงการ',
                project_user:[
                    {id:1,name:'นายพเยาว์ สนพลาย'},
                    {id:1,name:'นายพเยาว์ สนพลาย เปลี่ยน'},
                    {id:1,name:'นายพเยาว์ สนพลาย //33'},
                ]
            },
                {
                id: 2023002,
                name:'โครงการ22',
                name_x:0,
                name_y:69,
                project_user:[
                    {id:1,name:'นายพเยาว์ สนพลาย'},
                    {id:1,name:'นายพเยาว์ สนพลาย เปลี่ยน'},
                    {id:1,name:'นายพเยาว์ สนพลาย //33'},
                ]
            }
            ],
            isLoading : false,
        }
    },
    mounted(){
        this.get_projects()
    },
    
    methods: {
       get_projects(){
            axios.get('./api/cert/get_projects.php')
                .then(response => {
                    if (response.data.status) {
                        this.datas = response.data
                        this.projects = response.data.projects
                        console.log(response.data)
                    } 
                })
                .catch(function (error) {
                    console.log(error);
                })
                .finally(() => {
                    this.isLoading = false;
                })
        
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
                        console.log(url)
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
      add_users(id){
        axios.post('./api/cert/add_users.php',{project_id:id})    
            .then(response => {
                // this.alert(icon,message,timer=0)
                this.get_projects()
            })
            .catch(function (error) {
                console.log(error);
            });
      },
      del_user(id){
        axios.post('./api/cert/del_user.php',{id:id})    
            .then(response => {
                // this.alert(icon,message,timer=0)
                this.get_projects()
            })
            .catch(function (error) {
                console.log(error);
            });
      },

     
    //   alert(icon,message,timer=0){
    //     swal.fire({
    //       icon: icon,
    //       title: message,
    //       showConfirmButton: false,
    //       timer: timer
    //     });
    //   },
    },
  
  }).mount('#index1')

  