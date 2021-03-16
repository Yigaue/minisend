<template>
    <div>
       <div class="box box-primary container">
            <div class="box-header with-border">
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="row">
                   <div class="col-md-8">
                        <h3>{{ email.subject }}</h3>
                        <h5>From: <b>{{ email.user.name }}</b>  {{ email.user.email }}</h5>
                    </div>
                    <div class="col-md-4">
                        <span class="mailbox-read-time pull-right"> {{ email.created_at }} </span></h5>
                    </div>
              </div>
              <!-- /.mailbox-read-info -->

              <!-- /.mailbox-controls -->
              <div class="mailbox-read-message mt-5">
               {{ email.content }}
              </div>
              <!-- /.mailbox-read-message -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer row mt-5">
                <p><b>Attachments</b></p>
              <ul class="mailbox-attachments clearfix">
                <li v-for="attachment in attachments" :key="attachment.id">
                  <span class="mailbox-attachment-icon"></span>
                  <div class="mailbox-attachment-info">
                    <a :href="file_url" class="mailbox-attachment-name" @click="setFileUrl(attachment.file_url)"> {{ attachment.file_name }}</a>
                  </div>
                </li>

              </ul>
            </div>
            <div class="mailbox-controls pull-right">
                <div class="btn-group">
                  <button type="button" @click="deleteEmail(email_id)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-container="body" title="" data-original-title="Delete">
                    Delete</button>
                </div>
              </div>
          </div>
    </div>
</template>


<script>
export default {
    props: ["id"],

    data () {
        return {
            email: {},
            email_id : this.id,
            attachments : [],
            file_url: ''
        }
    },

    created() {
        this.fetchEmail(this.email_id);
    },

    methods: {
        fetchEmail(id) {
            axios.get(`/api/v1/emails/${id}`, '',

                {'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer '}
            )
            .then(response => {
                this.email = response.data.data;
                this.attachments = response.data.data.attachments;
               console.log(response)
            })
        },
        deleteEmail(id) {
            axios.delete(`/api/v1/emails/${id}`).
            then(response => {
                console.log(response);
            })
        },
        setFileUrl(file_name) {
            this.file_url = `/storage/email_attachment/${file_name}`
        }
    }
}
</script>

<style scoped>
.container {
    margin-top: 5%;
    padding: 2%;
    background-color: rgba(245, 245, 245, 0.801);
}
li {
    list-style: none;
}
</style>
