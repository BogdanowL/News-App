<template>
<div>
    <h1>Все записи</h1>
    <h3 class="d-flex float-right"> </h3>
    <div class="row">
        <div class="col-sm-6">
            <form @submit.prevent="addNews()" class="mb-4">
                <div class="form-group">
                    <label for="title">Название</label>
                    <input v-model="note.title" type="text" class="form-control" id="title" >
                </div>
                <div class="form-group">
                    <label for="description">Описание</label>
                    <input v-model="note.description" type="text" class="form-control" id="description" >
                </div>
                <div class="form-group">
                    <label for="text">Текст</label>
                    <textarea v-model="note.text" class="form-control" id="text" rows="3"></textarea>
                </div>
                <button v-if="edit === false" type="submit" class="btn btn-primary">Добавить</button>
                <button v-else type="submit" class="btn btn-success">Сохранить</button>
            </form>

        </div>
    </div>
    <div v-if="errored" class="alert alert-danger text-center" role="alert">
        Новости не загрузились :(
    </div>
    <table v-else class="table table-striped">
        <div v-if="loading">Загрузка...</div>
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Автор</th>
            <th scope="col">Название</th>
            <th scope="col">Описание</th>
            <th scope="col">Текст</th>
            <th scope="col">Теги</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="note in news" :key="note.id">
            <th >{{ note.id }}</th>
            <th v-for="value in note.author">
                 {{ value }}
            </th>
            <td>{{ note.title }}</td>
            <td>{{ note.text.substr(0, 80) + '...' }}</td>
            <td>{{ note.text }}</td>
            <td>tags</td>
            <td class="">
                <div class="d-inline-block">
                    <button @click="editNews(note)" class="btn mt-2 btn-success">
                        <i class="fas fa-pencil-alt"></i>
                    </button>
                    <button @click="deleteNews(note.id)" class="btn mt-2 btn-danger">
                        <i class="far fa-times-circle"></i>
                    </button>
                </div>

            </td>
        </tr>

        </tbody>
    </table>

    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li :class="{ disabled: !pagination.prev_page_url }"
                @click.prevent="getNews(pagination.prev_page_url)"
                class="page-item">
                <a class="page-link" href="#">Назад</a>
            </li>
            <li class="page-item">
                <a @click.prevent="getNews(pagination.first_page_url)"  class="page-link" href="#"> 1 </a>
            </li>
            <li class="page-item disabled">
                <a class="page-link " href="#"> страница: {{ pagination.current_page }}</a>
            </li>
            <li class="page-item">
                <a  @click.prevent="getNews(pagination.last_page_url)"
                    class="page-link" href="#">{{ pagination.last_page }}</a>
            </li>
            <li :class="{ disabled: !pagination.next_page_url }"
                @click.prevent="getNews(pagination.next_page_url)"
                class="page-item">
                <a class="page-link" href="#">Следующая</a>
            </li>
        </ul>
    </nav>


</div>
</template>

<script>
    export default {
        data() {
            return  {
                news: [],
                note: {
                    id: '',
                    title: '',
                    description: '',
                    text: '',
                    author: []

                },
                user: {},
                author: '',
                pagination: {},
                edit: false,
                loading: true,
                errored: false,
            }
        },
        mounted() {
            this.getUser()
            this.getNews()
        },
        // computed: {
        //     getAuthor(author){
        //         let test =  Object.values(this.note.author)
        //         test = test.flat()
        //
        //         console.log(test)
        //         }
        //     },
        methods: {
            getAuthor(value) {

                console.log(value)
            },
            getUser() {
                axios
                    .get('/user')
                    .then(response =>{
                        this.user = response.data
                    })
                    .catch(error => {
                        console.log(error)
                        this.errored = true;
                    })
                    .finally(() => {

                        this.loading = false});
            },
            getNews(page_url) {
                page_url = page_url || '/api/news'
                axios
                    .get(page_url)
                    .then(response => {
                        this.news = response.data.data
                        this.makePagination(response.data)
                       // console.log(response.data.data)
                    })
                    .catch(error => {
                        console.log(error)
                        this.errored = true;
                    })
                    .finally(() => this.loading = false);
            },
            makePagination(response) {
                let pagination = {
                    current_page: response.current_page,
                    last_page: response.last_page,
                    first_page_url: response.first_page_url,
                    last_page_url: response.last_page_url,
                    prev_page_url: response.prev_page_url,
                    next_page_url: response.next_page_url,
                    per_page: response.per_page
                }
                this.pagination = pagination

            },
            deleteNews(id){
                axios
                    .delete(`/api/posts/${id}`)
                    .then(response => {
                        console.log(response)
                        this.getNews()
                    })
                    .catch(error => console.log(error))
            },
            addNews() {
                if (this.edit === false)
                {
                    //добавление
                    axios
                        .post('api/news', {
                            title: this.note.title,
                            description: this.note.description,
                            text: this.note.description,
                            user: this.user.id
                        })
                        .then(response => {
                            this.post.title = ''
                            this.post.description = ''
                            this.getNews()
                        })
                        .catch(error => console.log(error))
                }else {
                    axios
                        .put(`api/news/${this.note.id}`, {
                            title: this.note.title,
                            description: this.note.description,
                            text: this.note.text
                        })
                        .then(response => {
                            this.note.title = ''
                            this.note.description = ''
                            this.note.text = ''
                            this.getNews()
                        })
                        .catch(error => console.log(error))
                        .finally(() => this.edit = false);
                }
            },

            editNews(note) {
                this.edit = true
                this.note.id = note.id
                this.note.title = note.title
                this.note.description = note.description
                this.note.text = note.description
            }

        }
    }
</script>

<style scoped>

</style>
