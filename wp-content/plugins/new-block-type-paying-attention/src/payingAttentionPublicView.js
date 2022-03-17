import React from 'react'
import ReactDOM from 'react-dom'
import './payingAttentionPublicView.scss'

const divsToUpdate = document.querySelectorAll(".paying-attention-update-me")

divsToUpdate.forEach((div) => {
  const data = JSON.parse(div.querySelector("pre").innerHTML)
  ReactDOM.render(<Quiz {...data}/>, div)
  div.classList.remove(".paying-attention-update-me")
})

function Quiz(props) {
  return (
    <div className="paying-attention-frontend">
      <p>{props.question}</p>
      <ul>
        {props.answers.map(function (answerSelectd) {
          return <li>{answerSelectd}</li>
        })}
      </ul>
    </div>
  )
}