<template>
  <div class="wrapper">
    <PageHeader class="header">Авторизация</PageHeader>


    <div class="logo">
      <img class="logo_img" :src="$store.state.logo" alt="">
    </div>

    <form action="" @click="formSubmit" class="form">
      <AuthInput
          v-for="(el, index) in inputs"
          :key="index"
          :name="el.vmod"
          v-model:value="el.value"
          v-model:error="el.error"

          :inputInfo="el"
      ></AuthInput>



      <div class="btn_send_block" v-if="error">
        <div class="error_mes">{{error}}</div>
        <BlueBtn  class="disable" :arrow="true">Войти</BlueBtn>
      </div>
      <BlueBtn v-else @click="enterClick" :arrow="true">Войти</BlueBtn>


    </form>

    <div class="btn_link_box">
      <div class="btn_link" @click="$router.push('/recover')">Забыли свой пароль?</div>
      <div class="btn_link" @click="$router.push('/register')">Регистрация</div>
    </div>

    <PrivacyPolicy class="privacy">Входя в аккаунт</PrivacyPolicy>
  </div>
</template>

<script>
import {mapMutations, mapActions, mapState} from 'vuex'
import PageHeader from "@/components/ui/PageHeader";
import PrivacyPolicy from "@/components/ui/btn/PrivacyPolicy";
import AuthInput from "@/components/ui/input/AuthInput";
import BlueBtn from "@/components/ui/btn/BlueBtn";

export default {
  name: "AuthPage",
  components: {
    PageHeader,
    PrivacyPolicy,
    AuthInput,
    BlueBtn
  },
  data() {
    return {
      inputs: [
        {
          f_icon: require('@/assets/icon/form/mail.svg'),
          title: 'E-mail',
          l_icon: '',
          vmod: 'mail',
          value: '',
          error: null,
        },
        {
          f_icon: require('@/assets/icon/form/pass.svg'),
          title: 'Пароль',
          l_icon: require('@/assets/icon/form/eye.svg'),
          vmod: 'pass',
          value: '',
        },
      ],
      error: null,
      allowFlag: []
    }
  },

  methods: {
    ...mapMutations({
      setLoginData: 'auth/setLoginData',
    }),
    ...mapActions({
      authRequest: 'auth/authRequest',
    }),

    enterClick() {
      let values = []
      let errors = []

      this.inputs.forEach((el) => {
        if(el.error) {
          errors.push(el.error)
        } else {
          if(el.value) {
            values[el.vmod] = el.value
          } else {
            errors.push('empty ' + el.vmod)
          }
        }

      })

      if(!this.errors){
        console.log('values', values)
        values['type'] = 'newLogin'

        this.setLoginData(values)

        this.authRequest()
      }

      console.log('this.value',values)
      console.log('this.errors',errors)


      // const data = {
      //   login: 'fds',
      //   pass: 'fdsfs'
      // }

      console.log(this.loginData, 'this.setLoginData')
      //

      // this.authRequest()

      // this.$store.dispatch('authSuccess');
      // this.$router.push('/main')
    },

    formSubmit(e) {
      e.preventDefault()
    },

  },

  computed: {
    ...mapState({
      loginData: state => state.auth.loginData,
      loginError: state => state.auth.loginError,
    })
  },
  watch: {
    focusLeave(el) {
      if (el.error) {
        console.log('err tru')
        this.errors = true
      } else {
        console.log('err false')
        this.errors = false
      }
    }
  }
}
</script>

<style lang="less" scoped>
.wrapper {
  position: relative;
  background: #FFFFFF;
  width: 100vw;
  margin: 0 auto;
  height: 100vh;
  text-align: center;
  padding: 0 24px;
  padding-top: 35px;

  .logo {
    margin-top: 149px;
  }

  .form {
    display: flex;
    margin-top: 52px;
    flex-direction: column;
    gap: 32px;
  }

  .btn_send_block{
    position: relative;

    .error_mes{
      position: absolute;
      left: 10px;
      top: -22px;
      color: #FF6262;
    }

  }

  .btn_link_box {
    margin-top: 13px;
    display: flex;
    flex-direction: column;
    align-items: center;
    flex-wrap: nowrap;

    .btn_link {
      display: inline-block;
      margin-bottom: 8px;
      text-decoration: underline;
      color: #43BAC0;
    }
  }

  .disable {
    background: #8A8A8E;
    cursor: not-allowed;
  }

  .privacy {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    text-align: center;
    bottom: 45px;
  }
}
</style>