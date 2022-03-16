import './index.scss'
import {TextControl, Flex, FlexBlock, FlexItem, Button, Icon} from "@wordpress/components"

wp.blocks.registerBlockType("ourplugin/are-you-paying-attention", {
  title: "Are You Paying Attention?",
  icon: "smiley",
  category: "common",
  attributes: {
    question: {type: "string"},
    answers: {type: "array", default: ["red", "blue"]}
  },
  edit: EditComponent,
  save: function (props) {
    // with `null` we remove the responsibility of the output from JS to PHP
    return null
  }
})

function EditComponent(props) {
  function updateQuestion(value) {
    props.setAttributes({question: value})
  }

  return (
    // whatever the function returns, it's the user interface
    <article className="paying-attention-edit-block">
      <TextControl label="Question:" value={props.attributes.question} onChange={updateQuestion} style={{fontSize: "20px"}} />
      <p style={{fontSize: "13px", margin: "20px 0 8px 0"}}>Answers:</p>
      {props.attributes.answers.map( (answer, index) => {
        return (
          <Flex>
            <FlexBlock>
              <TextControl value={answer} onChange={newValue => {
                const newAnswers = props.attributes.answers.concat([])
                newAnswers[index] = newValue
                props.setAttributes({answers: newAnswers})
              }}/>
            </FlexBlock>

            <FlexItem>
              <Button>
                <Icon className="mark-as-correct" icon="star-empty" />
              </Button>
            </FlexItem>

            <FlexItem>
              <Button isLink className="attention-delete">Delete</Button>
            </FlexItem>
          </Flex>
        )
      })}
      <Button isPrimary>Add another answer</Button>
    </article>
  )
}