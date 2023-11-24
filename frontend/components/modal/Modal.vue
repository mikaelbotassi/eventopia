<template>
    <div class="my-modal w-full">
        <div class="my-modal-inner">
            <slot></slot>
        </div>
    </div>
</template>

<style>
  .my-modal{
      position:fixed;
      top:0;
      left:0;
      height: 100%;
      width: 100%;
      background-color: rgba(0,0,0,0.5);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 1000;
  }

  .my-modal-inner{
    color: #fff;
    background-color: var(--dark);
    border-radius: 1rem;
    -webkit-box-shadow: 0px 7px 95px -47px rgba(0,0,0,0.75);
    -moz-box-shadow: 0px 7px 95px -47px rgba(0,0,0,0.75);
    box-shadow: 0px 7px 95px -47px rgba(0,0,0,0.75);
    min-width: 60%;
    max-width: 80%;
    max-height: 90%;
    overflow-y: auto;
  }

</style>