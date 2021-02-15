<template>
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <h1>Emails</h1>
            </div>
            <div class="col-md-8">
                <input class ="form-control" type="search" value="" placeholder="Search mails">
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary pull-right">Compose</button>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <table class="table-x">
                    <tbody>
                        <a href="" class="table-link">
                            <tr v-for="email in emails" :key="email.id">
                            <hr>
                                <div class="entry-x row">
                                    <div class="col-md-3 alias">
                                        <td><input type="checkbox"></td>
                                        <td class="name">{{ email.alias }}</td>
                                    </div>
                                    <div class="col-md-9">
                                        <td class="subject"><b>{{ email.subject }}</b> - {{ email.text_content.substring(0, 100) }}...
                                        </td>
                                        <td class="date">{{ email.formated_date }}</td>
                                    </div>
                                </div>
                                <div class="entry-y row">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-9">
                                        <td class="attachment">
                                            <span v-for="attachment in email.attachments" :key="attachment.id" class="attachment-item mr-3">{{ attachment.created_at }}</span>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            </a>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</template>

<style scoped>
.container {
    margin-top: 5%;
}
a:link {
  text-decoration: none;

}
.table-link{
    color: rgb(0, 0, 0)
}
  .entry-x:hover {
     box-shadow: 0px 1px 1px 0px #888888;
     border-radius: 5px;
     border-top: 0px;

}

.table-x {
    border-collapse: collapse;
    width: 100%;
    margin-bottom: 5%;
}

th, td {
  text-align: left;
  padding-left: 10px;
}

.attachment-item {
    border: 0.5px solid rgb(212, 210, 210);
    border-radius: 30px;
    color:#888888;
}

</style>
<script>
    export default {
        data () {
            return {
                emails: []
            }
        },
        created() {
            this.fetchEmails();
        },

        methods: {
            fetchEmails () {
                fetch('/api/emails')
                .then(response => response.json())
                .then(response => {
                    this.emails = response.data
                }).catch(error => console.log(error))
            }
        }
    }
</script>
