<template>
    <div class="container">
        <h1>New message</h1>
        <form @submit.prevent enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-10">
                    <div class="form-group">
                        <input type="email" name="to" placeholder="To" v-model="to" class="form-control">
                    </div>
                    <hr>
                    <div class="form-group">
                        <input type="text" name="subject" placeholder="Subject" v-model="subject" class="form-control">
                    </div>
                    <hr>
                    <div class="form-group">
                        <textarea name="content" id=""  v-model="content" placeholder="Your message..."></textarea>
                    </div>
                    <hr>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-8">
                    <input type="file" class="form-control file" placeholder="file" name="email_attachment" multiple id="file" ref="files" v-on:change="handleFileUpload()" /> <span class="bg-info">Use the shift key to select multiple files</span>
                </div>
                <div class="col-md-4">
                    <button @click="addAttachment()" class="btn btn-primary">Add Files</button>
                </div>
                <br>
            </div>
        </form>

        <div v-for="(file, index) in email_attachment" class="files row bg-light" :key="file.name">
            <div class="col-md-8">
                <p class="remove-file"> {{ file.name }} </p>
            </div>
            <div class="col-md-4">
                <p class="btn btn-sm btn-danger pull-right" @click="removeAttachment( index )">X</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8"></div>
            <div class="col-md-4">
                <button class="btn btn-success" @click="sendMail">Send</button>
            </div>
        </div>
    </div>


</template>

<style scoped>
.container {
    margin-top: 1%;
    padding: 2%;
    background-color: rgba(245, 245, 245, 0.801);
}
.controls {
    background-color: rgba(243, 242, 242, 0.801);
}

input {
    border: none;
    margin-bottom: 0px;
    padding: 10px;
    width: 700px;
    height: 20%;
    background-color: rgba(245, 245, 245, 0.801);
}
hr {
    width: 1000px;
}

input[type="file"]{
    position: absolute;
    visibility: hidden;
  }

span.remove-file{
    cursor: pointer;
}
 div.files{
    width: 800px;
  }

.file {
    width: auto;
    height: auto;
    padding: 0px;
    margin-bottom: 0px;
}

textarea {
    width:1000px ;
    border: none;
    background-color: rgba(245, 245, 245, 0.801);
    resize: none;
    height: 300px;
    padding: 10px;
}
</style>

<script>
export default {

    data () {
        return {
            subject: '',
            'to': '',
            content: '',
            'email_attachment' : []
        }
    },

    methods: {

        resetInputs() {
            this.subject = '',
            this.to = '',
            this.content = '',
            this.email_attachment = ''
        },

        sendMail() {
            let formData = new FormData();

            for( var i = 0; i < this.email_attachment.length; i++ ){
            let file = this.email_attachment[i];

            formData.append('files[' + i + ']', file);

            formData.append('data', JSON.stringify({
                subject: this.subject,
                'to': this.to,
                'content': this.content
            } ) );
}
            axios.post('/api/v1/emails',
                formData,
                {
                    headers: {
                    'Content-Type': 'multipart/form-data',
                }
            }).then(response => {
                console.log(response);
            })
            .catch(error => {
                console.log(error);
            });

            this.resetInputs();
        },

        handleFileUpload() {
           let uploads = this.$refs.files.files;
            for( var i = 0; i < uploads.length; i++ ) {
                this.email_attachment.push( uploads[i] );
            }
        },

         removeAttachment( key ) {
            this.email_attachment.splice( key, 1 );
        },

         addAttachment(){
        this.$refs.files.click();
      },
    }

}
</script>
