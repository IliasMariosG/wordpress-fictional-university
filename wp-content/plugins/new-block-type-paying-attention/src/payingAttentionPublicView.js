import './payingAttentionPublicView.scss'

const divsToUpdate = document.querySelectorAll(".paying-attention-update-me")

divsToUpdate.forEach((div) => {
  div.innerHTML = "Hello"
})