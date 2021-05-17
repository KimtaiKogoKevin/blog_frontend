<template>
    <div>
       <div class="container">
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20 col-md-4">

                         <div class="login_header" >
                             <h1>Login To Dashboard</h1>
                         </div>
                            <div class="space">
                              <input  type="email" v-model="data.email" placeholder=Email />
							  </div>

                             <div class="space">
                              <input  type="password" v-model="data.password" placeholder="Password" />
							  </div>
                              <div class="login_footer">
                                  <button type="primary" @click="login"  > Login </button>
                              </div>
                    </div>
                 </div>
        </div>
</template>

<script>
export default {
    data(){
    return {
        data : {
            email: '',
            password:''

        },
    }
  },

  methods: {
      async login(){
       
        const res = await this.callApi('post','/login',this.data)
        if (res.status==200) {
            console.log(res.data.msg)
            window.location = '/'
        }
        else{
            if (res.status==401) {
                console.log(res.data.msg)
            }
            else if(res.status==422){
                 for(let i in res.data.errors){
				console.log(res.data.errors[i] [0])

                   }
            }
            else{
                console.log('error')
            }

        }

          this.isLogging=false

       }
   }
}
</script>

<style  scoped>
._1adminOverveiw_table_recent{
    margin: 0 auto;
    margin-top: 20%;
}

.login_footer{
    text-align: center;
}

.login_header{
    margin: 0 auto;
    text-align:center;
}

</style>