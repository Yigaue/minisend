<template>
    <div class="container">
        <h1>New message</h1>
        <form @submit.prevent enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6 form-group">
                 <input type="email" name="from" placeholder="From" v-model="from" class="form-control">
                <hr>
                <input type="email" name="to" placeholder="To" v-model="to" class="form-control">
                <hr>
                <input type="text" name="subject" placeholder="Subject" v-model="subject" class="form-control">
                <hr>
                <input type="text" name="alias" placeholder="Sender alias" v-model="alias" class="form-control">
                <hr>
            </div>
        </div>
        <br>

        <div class="row mt-5">
            <div class="col-md-6 form-group">
                <textarea name="content" id=""  v-model="content" placeholder="Your message..."></textarea>
            </div>
        </div>
        <div class="row mb-4 controls">
            <div class="col-md-6 form-group">
                <input type="file" class="form-control file" placeholder="file" name="email_attachment" multiple id="file" ref="file" v-on:change="handleFileUpload()" />
            </div>
             <div class="col-md-6 form-group">
                <button class="btn btn-primary" @click="sendMail">Send</button>
            </div>
        </div>
        </form>
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
            'from': '',
            alias: '',
            subject: '',
            'to': '',
            content: '',
            'email_attachment' : []
        }
    },

    created () {

    },

    methods: {
        sendMail() {
             let formData = new FormData();
            formData.append('file', this.file);
            console.log('>> formData >> ', formData);

            axios.post('/api/emails',
            JSON.stringify({
                'from' : this.from,
                alias: this.alias,
                subject: this.subject,
                'to': this.to,
                'content': this.content
            }),

            {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                 }
            })
            .then(response =>{
                console.log(response);
            });

            this.resetInputs();
        },

        resetInputs() {
            this.from = '',
            this.alias = '',
            this.subject = '',
            this.to = '',
            this.content = ''
        },

        submitFile() {
            let formData = new FormData();
            formData.append('file', this.file);
            console.log('>> formData >> ', formData);

            // You should have a server side REST API
            axios.post('/api/fileupload',
                formData,
                {
                    headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }
        ).then(function () {
          console.log('SUCCESS!!');
        })
        .catch(function () {
          console.log('FAILURE!!');
        });
    },
    handleFileUpload() {
      this.file = this.$refs.file.files[0];
      console.log('>>>> 1st element in files array >>>> ', this.file);
    }
    }

}
</script>
