<template>
    <div class="table-container">
        <h1>Posts</h1>
        <table class="table" v-if="posts.length">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Comments</th>
                    <th scope="col">Author</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr scope="row" v-for="post in posts" :key="post.id">
                    <td>{{ post.title }}</td>
                    <td>{{ post.comments_count }}</td>
                    <td>{{ post.user.name }}</td>
                    <td><button v-if="idUser == post.idUser">hi</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<style>
.table-container {
    overflow: auto;
}

.checkerboard td {
    background-color: #f8f9fa;
}

.checkerboard td:nth-child(odd) {
    background-color: #e9ecef;
}
</style>
<script>
import axios from '../../axios.js';

export default {
    data() {
        return {
            posts: [],
            idUser: sessionStorage.getItem("idUser"),
        };
    },
    created() {
        axios.get('all.posts', {
            headers: {
                Authorization: `Bearer ${sessionStorage.getItem('API_KEY')}`
            }
        })
            .then(response => {
                this.posts = response.data.posts;
            })
            .catch(error => {
                console.log(error);
            });
    }
};
</script>