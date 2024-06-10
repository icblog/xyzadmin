<template>
  <footer className="footer-wrapper">
    <div class="container">
      <div class="row">
        <div class="col-md-10 mx-auto">
          <p class="text-center">
            <i class="fa fa-copyright" aria-hidden="true"></i> {{ copyRightData }}
          </p>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
const copyRightData = `${new Date().getFullYear()} ic-admin.icblog.uk`;
</script>
