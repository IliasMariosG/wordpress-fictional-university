import { ToolbarGroup, ToolbarButton } from "@wordpress/components"
import { RichText, BlockControls } from "@wordpress/block-editor"

wp.blocks.registerBlockType("ourblocktheme/genericheading", {
  title: "Generic Heading",
  attributes: {
    text: {type: "string"},
    size: {type: "string", default: "large"}
  },
  edit: EditComponent,
  save: SaveComponent
})

function EditComponent(props) {
  function handleTextChange(x) {
    props.setAttributes({text: x})
  }

  return (
    <>
      <BlockControls>
        <ToolbarGroup>
          <ToolbarButton isPressed={props.attributes.size === "large"} onClick={() => props.setAttributes({size: "large"})}>Large</ToolbarButton>
          <ToolbarButton isPressed={props.attributes.size === "medium"} onClick={() => props.setAttributes({size: "medium"})}>Medium</ToolbarButton>
          <ToolbarButton isPressed={props.attributes.size === "small"} onClick={() => props.setAttributes({size: "small"})}>Small</ToolbarButton>
        </ToolbarGroup>
      </BlockControls>
      <RichText allowedFormats={["core/bold"]} tagName="h1" className={`headline headline--${props.attributes.size}`} value={props.attributes.text} onChange={handleTextChange} />
    </>
  )
}

function SaveComponent(props) {
  function createTagName() {
    switch (props.attributes.size) {
      case "large":
        return "h1"
        break;
        case "medium":
          return "h2"
          break;
          case "small":
            return "h3"
            break;
      default:
        break;
    }
  }
  return <RichText.Content tagName={createTagName()} value={props.attributes.size} className={`headline headline--${props.attributes.size}`} value={props.attributes.text} />
}