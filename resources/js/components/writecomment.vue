<template>
  <div class="cmnt_frm mar_t30">
    <h2 class="post_dtls_title2 pad_b20">Leave A Comment</h2>
    <div class="cmnt_frm_all">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <div class="cmnt_input">
            <p class="mar_b10">MESSAGE</p>
            <textarea
              placeholder="Type your comment"
              name="message"
              v-model.lazy="data.commentTxt"
              required=""
            ></textarea>
          </div>
        </div>
        <div class="dtls_frm_btn mar_t20">
          <a href= "/blog/{slug}" @click="addComment">Enter Comment</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      data: {
        commentTxt:'',
      },
      comments : [],
      isset:false 
    };
  },
  methods: {
    async addComment(){
      const res = await this.callApi("post", "/addcomment", this.data);
      if (res.status === 200) {
        //this.console.log(this.data)
			this.comments.unshift(res.data)
      this.data.commentTxt=''
      window.location = "/"

      }else{
        if (res.status===422) {
				if (res.data.errors.commentTxt) {
        this.console.log('422 error');
        	}
			}
      else {
        this.console.log('something went wrong');
      }
      }
    },

  },
  
}
</script>
