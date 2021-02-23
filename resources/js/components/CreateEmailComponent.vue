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
                <input type="file" class="form-control file" placeholder="file" name="attachment" multiple id="file" ref="file" v-on:change="handleFileUpload()" /> <span class="bg-info">Use the shift key to select multiple files</span>
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

    methods: {

        resetInputs() {
            this.from = '',
            this.alias = '',
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
                'from' : this.from,
                alias: this.alias,
                subject: this.subject,
                'to': this.to,
                'content': this.content
            } ) );
}
            axios.post('/api/v1/emails',
                formData,
                {
                    headers: {
                    'Content-Type': 'multipart/form-data'
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
            this.email_attachment = this.$refs.file.email_attachment;
        }
    }

}
</script>
