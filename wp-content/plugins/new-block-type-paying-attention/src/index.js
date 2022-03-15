import './index.scss'
import {TextControl, Flex, FlexBlock, FlexItem, Button, Icon} from "@wordpress/components"

wp.blocks.registerBlockType("ourplugin/are-you-paying-attention", {
  title: "Are You Paying Attention?",
  icon: "smiley",
  category: "common",
  attributes: {
    skyColor: {type: "string"},
    grassColor: {type: "string"}
  },
  edit: EditComponent,
  save: function (props) {
    // with `null` we remove the responsibility of the output from JS to PHP
    return null
  }
})

function EditComponent(props) {
  function updateSkyColor(event) {
    props.setAttributes({skyColor: event.target.value})
  }

  function updateGrassColor(event) {
    props.setAttributes({grassColor: event.target.value})
  }

  return (
    // whatever the function returns, it's the user interface
    <article className="paying-attention-edit-block">
      <TextControl label="Question:"/>
      <p>Answers:</p>
      <Flex>
        <FlexBlock>
          <TextControl />
        </FlexBlock>

        <FlexItem>
          <Button>
            <Icon icon="star-empty"></Icon>
          </Button>
        </FlexItem>

        <FlexItem>
          <Button>Delete</Button>
        </FlexItem>
      </Flex>
    </article>
  )
}