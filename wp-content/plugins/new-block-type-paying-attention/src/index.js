import './index.scss'
import {TextControl, Flex, FlexBlock, FlexItem, Button, Icon, PanelBody, PanelRow, ColorPicker} from "@wordpress/components"
import {InspectorControls, BlockControls, AlignmentToolbar} from "@wordpress/block-editor"
import {ChromePicker} from "react-color"

(function() {
  let lockedUpdateButton = false
  wp.data.subscribe(function() {
    const results = wp.data.select("core/block-editor").getBlocks().filter((block) => {
      return block.name == "ourplugin/are-you-paying-attention" && block.attributes.correctAnswer == undefined
    })

    if (results.length && lockedUpdateButton == false) {
      lockedUpdateButton = true
      wp.data.dispatch("core/editor").lockPostSaving("noanswer")
    }

    if (!results.length && lockedUpdateButton == true) {
      lockedUpdateButton = false
      wp.data.dispatch("core/editor").unlockPostSaving("noanswer")
    }
  })
})()

wp.blocks.registerBlockType("ourplugin/are-you-paying-attention", {
  title: "Are You Paying Attention?",
  icon: "smiley",
  category: "common",
  attributes: {
    question: {type: "string"},
    answers: {type: "array", default: [""]},
    correctAnswer: {type: "number", default: undefined},
    backgroundColor: {type: "string", default: "#EBEBEB"},
    theAlignment: {type: "string", default: "left"}
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

  function deleteAnswer(indexToDelete) {
    const newAnswers = props.attributes.answers.filter((x, index) => {
      return index != indexToDelete
    })
    props.setAttributes({answers: newAnswers})

    if (indexToDelete == props.attributes.correctAnswer) {
      props.setAttributes({correctAnswer: undefined})
    }
  }

  function markAsCorrect(index) {
    props.setAttributes({correctAnswer: index})
  }

  return (
    // whatever the function returns, it's the user interface
    <article className="paying-attention-edit-block" style={{backgroundColor: props.attributes.backgroundColor}}>
      <BlockControls>
        <AlignmentToolbar value={props.attributes.theAlignment} onChange={(userValue) => props.setAttributes({theAlignment: userValue})}/>
      </BlockControls>
      <InspectorControls>
        <PanelBody title="Background Color" initialOpen={true}>
          <PanelRow>
            <ChromePicker color={props.attributes.backgroundColor} onChangeComplete={(x) => props.setAttributes({backgroundColor: x.hex})} disableAlpha={true} />
          </PanelRow>
        </PanelBody>
      </InspectorControls>
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
              <Button onClick={() => markAsCorrect(index)}>
                <Icon className="mark-as-correct" icon={props.attributes.correctAnswer == index ? "star-filled" : "star-empty"} />
              </Button>
            </FlexItem>

            <FlexItem>
              <Button isLink className="attention-delete" onClick={() => deleteAnswer(index)}>Delete</Button>
            </FlexItem>
          </Flex>
        )
      })}
      <Button isPrimary onClick={() => {
        props.setAttributes({answers: props.attributes.answers.concat([""])})
      }}>Add another answer</Button>
    </article>
  )
}