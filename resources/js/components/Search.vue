<template>
    <div>


        <div class="row">
            <div class="col-sm-6">
                <form @submit.prevent="getSearch(search)" class="mb-4">
                    <div class="form-group">
                        <label for="search">Поиск: <h5>{{search}}</h5></label>
                        <input v-model="search" type="text" class="form-control" id="search" >
                    </div>
                            <button  type="submit" class="btn btn-success">Найти</button>
                </form>

            </div>
        </div>

        <table v-if="note" class="table table-striped">

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
            <tr >
                <th >{{ note.id }}</th>
                <th>

                </th>
                <td ></td>
                <td>{{ note.text}}</td>
                <td>{{ note.description }}</td>
                <td>tags</td>
                <td class="">

                </td>
            </tr>

            </tbody>
        </table>



    </div>


</template>

<script>
    export default {
       data() {
           return {

               note: {},
               search: ''
           }
       },
       methods: {
           getSearch(search) {

               axios
               .get(`/api/news/${search}`)
               .then(response => {
                   this.note = response.data
               })
               .catch(error => {
                   console.log(error)

               })
           }
       }
    }
</script>

<style scoped>

</style>
