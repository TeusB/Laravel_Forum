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
                    <td><router-link :to="{ name: 'dashboardPost', params: { id: post.id } }">{{ post.title }}</router-link>
                    </td>
                    <td>{{ post.comments_count }}</td>
                    <td>{{ post.user.name }}</td>
                    <td><button v-if="$store.state.user.is_admin || $store.state.user.idUser == post.idUser"
                            @click="updatePost(post.id)">Update</button>

                        <button v-if="$store.state.user.is_admin || $store.state.user.idUser == post.idUser"
                            @click="deletePost(post.id)">Delete</button>
                    </td>
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
import { Form, Field } from 'vee-validate';
import axios from '../../axios.js';
export default {
    data() {
        return {
            posts: [],
        };
    },
    created() {
        axios.get('all.posts', {
            headers: {
                Authorization: `Bearer ${sessionStorage.getItem('API_TOKEN')}`
            }
        })
            .then(response => {
                this.posts = response.data.posts;
            })
            .catch(error => {
                console.log(error);
            });
    },
    methods: {
        updatePost(id) {
            this.$router.push({ name: 'dashboardUpdatePost', params: { id } });
        },
        deletePost(idPost) {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this post!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        axios.delete(`delete.post/${idPost}`, {
                            headers: {
                                Authorization: `Bearer ${sessionStorage.getItem('API_TOKEN')}`
                            }
                        })
                            .then(response => {
                                this.posts = this.posts.filter((post) => post.id !== idPost);
                                swal("Poof! The post has been deleted!", {
                                    icon: "success",
                                });
                                console.log(response);
                            })
                            .catch(error => {
                                console.log(error);
                                swal("Oops!", "Something went wrong. The post could not be deleted.", "error");
                            });
                    } else {
                        swal("Your post is safe!");
                    }
                });
        }
    },
};
</script>