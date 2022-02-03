<<template>
    <div>
        <el-card style="width: 550px; height: 400px;">
            <div class="flexed-column justify-center">
                <div>
                    <span>Register</span>
                </div>
                <el-form
                    ref="registerForm"
                    :model="registerModel"
                    :rules="rules"
                >
                    <el-form-item prop="name">
                        <el-input name="name" v-model="registerModel.name"></el-input>
                    </el-form-item>

                     <el-form-item prop="email">
                        <el-input name="email" v-model="registerModel.email"></el-input>
                    </el-form-item>


                     <el-form-item prop="password">
                        <el-input name="password" type="password" v-model="registerModel.password"></el-input>
                    </el-form-item>


                     <el-form-item prop="password_confirmation">
                        <el-input name="password_confirmation" type="password" v-model="registerModel.password_confirmation"></el-input>
                    </el-form-item>

                    <el-button>Register</el-button>

                </el-form>
            </div>

        </el-card>

    </div>
</template>

<script>
export default{
    data() {
        return {
            loading: false,
            registerModel: {},
            rules: {

            }
        }
    },
}
</script>

<style scoped>

</style>