<template>
  <div class="chatbot-container">
    <!-- Botón para abrir/cerrar -->
    <button 
      class="chatbot-toggle"
      @click="isOpen = !isOpen"
      :title="isOpen ? 'Cerrar chat' : 'Abrir chat'"
    >
      <span v-if="!isOpen" class="toggle-icon">💬</span>
      <span v-else class="toggle-icon">✕</span>
    </button>

    <!-- Ventana del chat -->
    <div v-if="isOpen" class="chatbot-window">
      <!-- Header -->
      <div class="chatbot-header">
        <h3>🤖 EcoBot</h3>
        <div class="header-actions">
          <button 
            @click="toggleLanguage"
            class="lang-toggle"
            :title="currentLanguage === 'es' ? 'Switch to English' : 'Cambiar a Español'"
          >
            {{ currentLanguage === 'es' ? '🇬🇧' : '🇪🇸' }}
          </button>
          <button @click="showStatement" class="info-btn" title="Declaración Transhumana">
            ℹ️
          </button>
        </div>
      </div>

      <!-- Modal de declaración -->
      <div v-if="showStatementModal" class="statement-modal">
        <div class="statement-content">
          <button @click="showStatementModal = false" class="close-btn">✕</button>
          <h2>{{ statementData.title }}</h2>
          <p class="statement-text">{{ statementData.statement }}</p>
          <div class="values-list">
            <h4>{{ currentLanguage === 'es' ? 'Valores' : 'Values' }}:</h4>
            <ul>
              <li v-for="value in statementData.values" :key="value">{{ value }}</li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Mensajes -->
      <div class="chatbot-messages">
        <div 
          v-for="(msg, idx) in messages" 
          :key="idx"
          :class="['message', msg.type]"
        >
          <div class="message-content">
            {{ msg.text }}
          </div>
        </div>
        <div v-if="isLoading" class="message bot">
          <div class="message-content loading">
            <span class="dot"></span><span class="dot"></span><span class="dot"></span>
          </div>
        </div>
      </div>

      <!-- Input -->
      <div class="chatbot-input">
        <input
          v-model="userMessage"
          type="text"
          :placeholder="currentLanguage === 'es' ? 'Escribe tu pregunta...' : 'Type your question...'"
          @keyup.enter="sendMessage"
          :disabled="isLoading"
        />
        <button @click="sendMessage" :disabled="isLoading || !userMessage.trim()">
          {{ currentLanguage === 'es' ? 'Enviar' : 'Send' }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Chatbot',
  data() {
    return {
      isOpen: false,
      currentLanguage: 'es',
      messages: [],
      userMessage: '',
      isLoading: false,
      showStatementModal: false,
      statementData: {},
    };
  },
  methods: {
    async sendMessage() {
      if (!this.userMessage.trim()) return;

      // Agregar mensaje del usuario
      this.messages.push({
        type: 'user',
        text: this.userMessage,
      });

      const message = this.userMessage;
      this.userMessage = '';
      this.isLoading = true;

      try {
        const response = await fetch('/api/chatbot/message', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            message: message,
            language: this.currentLanguage,
          }),
        });

        const data = await response.json();

        this.messages.push({
          type: 'bot',
          text: data.response,
        });
      } catch (error) {
        console.error('Error:', error);
        this.messages.push({
          type: 'bot',
          text: this.currentLanguage === 'es' 
            ? '❌ Error al procesar tu mensaje. Intenta de nuevo.'
            : '❌ Error processing your message. Try again.',
        });
      } finally {
        this.isLoading = false;
        this.$nextTick(() => {
          const messagesDiv = document.querySelector('.chatbot-messages');
          if (messagesDiv) {
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
          }
        });
      }
    },

    toggleLanguage() {
      this.currentLanguage = this.currentLanguage === 'es' ? 'en' : 'es';
    },

    async showStatement() {
      try {
        const response = await fetch(`/api/chatbot/statement?language=${this.currentLanguage}`);
        this.statementData = await response.json();
        this.showStatementModal = true;
      } catch (error) {
        console.error('Error:', error);
      }
    },

    initializeChat() {
      // Enviar mensaje inicial automáticamente
      this.userMessage = this.currentLanguage === 'es' ? 'hola' : 'hello';
      this.$nextTick(() => {
        this.sendMessage();
      });
    }
  },
  watch: {
    isOpen(newVal) {
      if (newVal && this.messages.length === 0) {
        this.$nextTick(() => {
          this.initializeChat();
        });
      }
    }
  }
};
</script>

<style scoped>
.chatbot-container {
  position: fixed;
  bottom: 20px;
  right: 20px;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  z-index: 9999;
}

.chatbot-toggle {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border: none;
  cursor: pointer;
  font-size: 28px;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  transition: all 0.3s ease;
  padding: 0;
}

.chatbot-toggle:hover {
  transform: scale(1.1);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
}

.chatbot-toggle:active {
  transform: scale(0.95);
}

.toggle-icon {
  display: inline-block;
}

.chatbot-window {
  position: absolute;
  bottom: 90px;
  right: 0;
  width: 380px;
  height: 500px;
  background: white;
  border-radius: 12px;
  box-shadow: 0 5px 40px rgba(0, 0, 0, 0.16);
  display: flex;
  flex-direction: column;
  overflow: hidden;
  animation: slideUp 0.3s ease;
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.chatbot-header {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 16px;
  font-size: 18px;
  font-weight: 600;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.chatbot-header h3 {
  margin: 0;
  font-size: 18px;
}

.header-actions {
  display: flex;
  gap: 10px;
}

.lang-toggle,
.info-btn {
  background: rgba(255, 255, 255, 0.2);
  border: none;
  color: white;
  cursor: pointer;
  padding: 6px 10px;
  border-radius: 6px;
  font-size: 16px;
  transition: background 0.2s;
}

.lang-toggle:hover,
.info-btn:hover {
  background: rgba(255, 255, 255, 0.3);
}

.chatbot-messages {
  flex: 1;
  overflow-y: auto;
  padding: 16px;
  display: flex;
  flex-direction: column;
  gap: 12px;
  background: #f8f9fa;
}

.message {
  display: flex;
  animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.message.user {
  justify-content: flex-end;
}

.message.bot {
  justify-content: flex-start;
}

.message-content {
  max-width: 70%;
  padding: 10px 14px;
  border-radius: 8px;
  word-wrap: break-word;
  white-space: pre-wrap;
  line-height: 1.4;
}

.message.user .message-content {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border-radius: 16px 4px 16px 16px;
}

.message.bot .message-content {
  background: white;
  color: #333;
  border: 1px solid #e0e0e0;
  border-radius: 4px 16px 16px 16px;
}

.message-content.loading {
  padding: 10px 14px;
}

.dot {
  display: inline-block;
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: #667eea;
  margin: 0 3px;
  animation: bounce 1.4s infinite;
}

.dot:nth-child(1) {
  animation-delay: -0.32s;
}

.dot:nth-child(2) {
  animation-delay: -0.16s;
}

@keyframes bounce {
  0%, 80%, 100% {
    opacity: 0.5;
    transform: translateY(0);
  }
  40% {
    opacity: 1;
    transform: translateY(-8px);
  }
}

.chatbot-input {
  display: flex;
  gap: 8px;
  padding: 12px;
  background: white;
  border-top: 1px solid #e0e0e0;
}

.chatbot-input input {
  flex: 1;
  border: 1px solid #ddd;
  border-radius: 6px;
  padding: 10px 12px;
  font-size: 14px;
  font-family: inherit;
  transition: border-color 0.2s;
}

.chatbot-input input:focus {
  outline: none;
  border-color: #667eea;
}

.chatbot-input input:disabled {
  background: #f5f5f5;
  cursor: not-allowed;
}

.chatbot-input button {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border: none;
  border-radius: 6px;
  padding: 10px 16px;
  cursor: pointer;
  font-weight: 600;
  transition: opacity 0.2s;
}

.chatbot-input button:hover:not(:disabled) {
  opacity: 0.9;
}

.chatbot-input button:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

/* Statement Modal */
.statement-modal {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.7);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 10000;
  border-radius: 12px;
}

.statement-content {
  background: white;
  padding: 24px;
  border-radius: 8px;
  max-height: 90%;
  overflow-y: auto;
  position: relative;
  max-width: 90%;
}

.close-btn {
  position: absolute;
  top: 12px;
  right: 12px;
  background: none;
  border: none;
  font-size: 24px;
  cursor: pointer;
  color: #999;
}

.close-btn:hover {
  color: #333;
}

.statement-content h2 {
  margin-top: 0;
  color: #667eea;
  font-size: 20px;
}

.statement-text {
  font-size: 14px;
  line-height: 1.6;
  color: #333;
  margin: 16px 0;
  padding: 12px;
  background: #f8f9fa;
  border-left: 4px solid #667eea;
  font-weight: 500;
}

.values-list {
  margin-top: 16px;
}

.values-list h4 {
  color: #667eea;
  margin-bottom: 8px;
}

.values-list ul {
  list-style: none;
  padding: 0;
}

.values-list li {
  padding: 6px 0;
  color: #555;
  font-size: 14px;
  margin-left: 12px;
}

.values-list li:before {
  content: "✓ ";
  color: #667eea;
  font-weight: bold;
  margin-right: 8px;
}

/* Responsive */
@media (max-width: 480px) {
  .chatbot-window {
    width: calc(100vw - 40px);
    height: 70vh;
    bottom: auto;
    top: 50%;
    right: 20px;
    transform: translateY(-50%);
  }

  .message-content {
    max-width: 85%;
  }
}
</style>
