<script setup>
defineProps({
    user: Object,
});
</script>

<template>
  <div class="bg-white shadow-md rounded-lg p-6 max-w-md mx-auto">
    <div class="flex items-center space-x-4">
      <img 
        :src="user.avatar" 
        alt="Avatar" 
        class="w-16 h-16 rounded-full border-2 border-gray-200 shadow-sm"
      />
      <div>
        <h1 class="text-xl font-semibold text-gray-800">{{ user.name }}</h1>
        <p class="text-sm text-gray-500">{{ user.email }}</p>
      </div>
    </div>
    <div class="mt-4 border-t border-gray-200 pt-4">
      <p class="text-sm text-gray-600">
        <strong>Google ID:</strong> {{ user.google_id }}
      </p>
    </div>
  </div>
</template>
